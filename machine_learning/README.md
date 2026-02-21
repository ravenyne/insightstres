# Machine Learning API - Stress Assessment

## Overview
This API serves as a backend service for predicting student stress levels using a Random Forest Classifier machine learning model. It receives questionnaire data from the main Laravel application and returns the analyzed stress category.

---

## 1. Local Development Setup

### 1.1. Prerequisites
Ensure you have Python 3.x and pip installed on your system.

### 1.2. Virtual Environment Setup
It is recommended to use a virtual environment to manage dependencies.

**Windows:**
```bash
cd machine_learning
python -m venv venv
venv\Scripts\activate
```

**Mac/Linux:**
```bash
cd machine_learning
python3 -m venv venv
source venv/bin/activate
```

### 1.3. Install Dependencies
Install required packages using the provided requirements file:

```bash
pip install -r requirements.txt
```

### 1.4. Running the API Server
Execute the following command to start the Flask development server:

```bash
python api/app.py
```

Expected Console Output:
```
Model loaded: ../models/stress_classifier.joblib
Features: 25 columns
Server running on: http://127.0.0.1:5000
```

### 1.5. Verification
Verify the API is running by accessing the health endpoint:

```bash
curl http://127.0.0.1:5000/health
```

---

## 2. Production Deployment (PythonAnywhere)

This guide details deploying the Flask API to PythonAnywhere, a popular Python hosting service.

### 2.1. Code Upload
1. Create an account at [PythonAnywhere](https://www.pythonanywhere.com/).
2. Navigate to the **Files** tab.
3. Upload your `machine_learning` directory.
   - *Tip:* Zip the folder locally, upload, and unzip via the **Bash Console** on the server.

### 2.2. Server Environment Setup
Open a **Bash Console** on PythonAnywhere and execute:

```bash
# Navigate to project directory
cd machine_learning

# Create virtual environment (Python 3.10)
mkvirtualenv --python=/usr/bin/python3.10 my-ml-env

# Install dependencies
pip install -r requirements.txt
```

### 2.3. Web App Configuration
1. Go to the **Web** tab.
2. Click **Add a new web app**.
3. Select **Manual configuration** (Select Python 3.10).
4. Configure the following paths:
   - **Source code:** `/home/USERNAME/machine_learning/api`
   - **Working directory:** `/home/USERNAME/machine_learning/api`
   - **Virtualenv:** `/home/USERNAME/.virtualenvs/my-ml-env`

### 2.4. WSGI Configuration
Edit the WSGI configuration file (link provided on the Web tab) and replace its content with:

```python
import sys
import os

# Add project path to system path
path = '/home/USERNAME/machine_learning/api'
if path not in sys.path:
    sys.path.append(path)

# Import Flask app as 'application'
from app import app as application
```
*Note: Replace `USERNAME` with your actual PythonAnywhere username.*

### 2.5. Finalize
1. Click the green **Reload** button on the Web tab.
2. Test the API: `http://USERNAME.pythonanywhere.com/health`.

---

## 3. API Documentation

### 3.1. Health Check
**Endpoint:** `GET /health`

Checks API status and model availability.

**Response:**
```json
{
  "status": "healthy",
  "model_loaded": true,
  "features_count": 25,
  "api_version": "1.0"
}
```

### 3.2. Predict Stress Level
**Endpoint:** `POST /predict`

Accepts questionnaire data and returns the predicted stress category.

**Request Body (JSON):**
```json
{
  "gender": 1,
  "age": 20,
  "have_you_recently_experienced_stress_in_your_life": 1,
  "have_you_noticed_a_rapid_heartbeat_or_palpitations": 0,
  ... (23 feature inputs)
}
```

**Response (JSON):**
```json
{
  "label": 1,
  "category": "Eustress"
}
```

**Label Mapping:**
- `0` = No Stress
- `1` = Eustress (Positive Stress)
- `2` = Distress (Negative Stress)

---

## 4. Troubleshooting

### 4.1. Connection Refused
**Issue:** Unable to connect to API.
**Resolution:**
- **Local:** Verify `python app.py` is running and port 5000 is open.
- **Production:** Check **Error Log** in PythonAnywhere Web tab.

### 4.2. Model Not Found
**Issue:** API returns model loading error.
**Resolution:**
- Ensure `models/stress_classifier.joblib` exists relative to the API script.
- Verify file permissions.

---

## 5. Laravel Integration

The Laravel application communicates with this API via HTTP requests. Configure the `.env` file in Laravel:

**Local Environment:**
```env
ML_API_URL=http://127.0.0.1:5000
```

**Production Environment:**
```env
ML_API_URL=http://USERNAME.pythonanywhere.com
```

**Data Flow:**
User Input -> Laravel Controller -> Flask API -> Model Prediction -> Database Storage -> User Interface