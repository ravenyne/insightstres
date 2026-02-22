from flask import Flask, request, jsonify
import joblib
import numpy as np
import os
import pandas as pd

app = Flask(__name__)

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# === PATH MODEL & FEATURE LIST ===
MODEL_PATH = os.path.join(BASE_DIR, "../models/stress_classifier.joblib")
FEATURE_PATH = os.path.join(BASE_DIR, "../models/feature_list_classifier.csv")

# Load model
model = joblib.load(MODEL_PATH)

# Load feature list (skip first row yang berisi "0")
df = pd.read_csv(FEATURE_PATH, header=None)
feature_list = df[0].tolist()[1:]  # Skip baris pertama


# --- Mapping Label ---
def map_label(lbl):
    lbl = int(lbl)

    if lbl == 0:
        return "No Stress"
    elif lbl == 1:
        return "Eustress"
    elif lbl == 2:
        return "Distress"
    else:
        return "Unknown"


@app.route("/predict", methods=["POST"])
def predict():
    data = request.json
    print("=== DATA DITERIMA DARI LARAVEL ===")
    print(data)

    features = []

    # Susun input sesuai urutan FEATURE LIST
    for feature in feature_list:

        # Handle nama kolom weight_change
        if feature in ["have_you_gained_lost_weight", "weight_change"]:
            features.append(data.get("weight_change", 0))
        else:
            features.append(data.get(feature, 0))

    arr = np.array(features).reshape(1, -1)
    
    print(f"=== FEATURES COUNT: {len(features)} ===")
    print(f"=== ARRAY SHAPE: {arr.shape} ===")

    # Prediksi label
    predicted_label = int(model.predict(arr)[0])

    category = map_label(predicted_label)

    return jsonify({
        "label": predicted_label,
        "category": category
    })


@app.route("/health", methods=["GET"])
def health():
    """Health check endpoint"""
    return jsonify({
        "status": "healthy",
        "model_loaded": model is not None,
        "features_count": len(feature_list),
        "api_version": "1.0"
    })


@app.route("/", methods=["GET"])
def index():
    """API info endpoint"""
    return jsonify({
        "name": "Stress Assessment ML API",
        "version": "1.0",
        "endpoints": {
            "/predict": "POST - Predict stress level",
            "/health": "GET - Health check"
        }
    })


if __name__ == "__main__":
    print("=" * 50)
    print("[-] Stress Assessment ML API")
    print("=" * 50)
    print(f"[+] Model loaded: {MODEL_PATH}")
    print(f"[+] Features: {len(feature_list)} columns")
    print(f"[+] Server running on: http://127.0.0.1:5000")
    print("=" * 50)
    app.run(port=5000, debug=True)