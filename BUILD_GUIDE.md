# 📱 Guru Crackers Customer Mobile App (Android APK) - Build Guide

This project is a standalone **Laravel 12 + NativePHP Mobile (Android)** customer application for **Guru Crackers, Sivakasi**.

---

## 🚀 Quick Step-by-Step: Production APK for Friends & Customers

### Step 1: Configure Production URL in `.env`
Open `.env` in this project folder (`gurucrackers-mobile/.env`) and ensure the backend URL points to your live Render server:

```env
BACKEND_API_URL="https://gurucrackers.onrender.com"
```

*(Note: If testing on local office Wi-Fi, you can set it to `http://192.168.1.8:8000`)*

---

### Step 2: Build the Signed Release APK
Run this single command inside `gurucrackers-mobile`:

```bash
php artisan native:package android --keystore=credentials/android.keystore --keystore-password=gurucrackers123 --key-alias=gurucrackers --key-password=gurucrackers123
```

---

### Step 3: Get Your APK File
Once the build finishes (takes ~45 seconds), your APK is ready at:
```bash
nativephp/android/app/build/outputs/apk/release/app-release.apk
```

You can copy and rename it for easy sharing:
```bash
cp nativephp/android/app/build/outputs/apk/release/app-release.apk ~/guru-crackers-v1.0.apk
```

Now you can share `guru-crackers-v1.0.apk` via WhatsApp, Telegram, or Google Drive with your friends and customers!

---

## 🔑 Keystore Credentials Reference
- **Keystore File:** `credentials/android.keystore`
- **Keystore Password:** `gurucrackers123`
- **Key Alias:** `gurucrackers`
- **Key Password:** `gurucrackers123`
- **Application ID:** `com.gurucrackers.customer`

---

## 📲 Installing on Connected Android Device (ADB)
If you have a phone connected via USB:
```bash
adb install -r -d -g nativephp/android/app/build/outputs/apk/release/app-release.apk
```
