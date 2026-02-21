import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
import joblib
import os

print("=== LOADING CLEAN CLASSIFIER DATASET ===")
df = pd.read_csv("../dataset/stress_clean_classifier.csv")

# =============================
# FEATURES & TARGET
# =============================
feature_cols = df.columns.tolist()
feature_cols.remove("label")

X = df[feature_cols]
y = df["label"]

print("\n=== FEATURES USED ===")
print(feature_cols)
print("\n=== LABEL DISTRIBUTION ===")
print(y.value_counts())

# =============================
# TRAIN TEST SPLIT
# =============================
X_train, X_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, random_state=42, stratify=y
)

# =============================
# RANDOM FOREST CLASSIFIER
# =============================
model = RandomForestClassifier(
    n_estimators=400,
    max_depth=20,
    random_state=42
)

model.fit(X_train, y_train)

# =============================
# SAVE MODEL + FEATURES
# =============================
os.makedirs("../models", exist_ok=True)
joblib.dump(model, "../models/stress_classifier_model.joblib")
pd.Series(feature_cols).to_csv("../models/feature_list_classifier.csv", index=False)

print("\n=== CLASSIFIER MODEL SAVED SUCCESSFULLY ===")