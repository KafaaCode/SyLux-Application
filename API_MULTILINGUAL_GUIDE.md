# 📱 دليل استخدام API مع دعم اللغات المتعددة

## 🌍 كيفية تحديد لغة المستخدم

### 1. استخدام Headers (الأولوية الأولى)

```http
GET /api/public/products
Accept-Language: ar,en;q=0.9,tr;q=0.8
X-Locale: ar
```

### 2. استخدام URL Parameters

```http
GET /api/public/products?locale=ar
GET /api/public/categories?locale=en
```

### 3. استخدام Cookies

```http
GET /api/public/products
Cookie: locale=ar
```

## 📋 أمثلة على الاستخدام

### 1. استرجاع المنتجات

```bash
# باللغة العربية (افتراضي)
curl -H "Accept-Language: ar" https://your-domain.com/api/public/products

# باللغة الإنجليزية
curl -H "X-Locale: en" https://your-domain.com/api/public/products

# باللغة التركية
curl "https://your-domain.com/api/public/products?locale=tr"
```

**الاستجابة:**
```json
{
  "status": "success",
  "message": "تم استرجاع المنتجات بنجاح",
  "data": [
    {
      "id": 1,
      "name": "منتج تجريبي",
      "description": "وصف المنتج التجريبي",
      "price": 100.00,
      "image": "https://your-domain.com/storage/products/image.jpg",
      "serial_number": "SN001",
      "request_number": "RN001",
      "active": true,
      "category": {
        "id": 1,
        "name": "فئة تجريبية",
        "image": "https://your-domain.com/storage/categories/category.jpg",
        "active": true,
        "country": {
          "id": 1,
          "name": "السعودية",
          "code": "SA",
          "active": true,
          "locale": "ar"
        },
        "specialization": {
          "id": 1,
          "name": "تغليف المواد الغذائية",
          "active": true,
          "locale": "ar"
        },
        "products_count": 5,
        "locale": "ar"
      },
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z",
      "locale": "ar"
    }
  ],
  "locale": "ar",
  "available_locales": {
    "en": "English",
    "ar": "العربية",
    "be": "Belgisch",
    "tr": "Türkçe",
    "nl": "Nederlands"
  },
  "timestamp": "2024-01-01T12:00:00.000000Z"
}
```

### 2. استرجاع الفئات

```bash
# جميع الفئات
curl -H "X-Locale: en" https://your-domain.com/api/public/categories

# فئة محددة
curl -H "X-Locale: tr" https://your-domain.com/api/public/categories/1

# فئات حسب الدولة والتخصص
curl -H "X-Locale: nl" "https://your-domain.com/api/public/categories/by-country-specialization?country_id=1&specialization_id=1"
```

### 3. استرجاع الدول والتخصصات

```bash
# الدول
curl -H "X-Locale: ar" https://your-domain.com/api/public/countries

# التخصصات
curl -H "X-Locale: en" https://your-domain.com/api/public/specializations

# اللغات المدعومة
curl https://your-domain.com/api/public/locales
```

## 🔧 للمطورين

### استخدام في JavaScript

```javascript
// تحديد اللغة من إعدادات الجهاز
const userLocale = navigator.language.split('-')[0];

// إرسال طلب مع اللغة
fetch('/api/public/products', {
  headers: {
    'Accept-Language': userLocale,
    'X-Locale': userLocale,
    'Content-Type': 'application/json'
  }
})
.then(response => response.json())
.then(data => {
  console.log('البيانات باللغة:', data.locale);
  console.log('المنتجات:', data.data);
});
```

### استخدام في Flutter/Dart

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  static const String baseUrl = 'https://your-domain.com/api/public';
  
  static Future<Map<String, dynamic>> getProducts(String locale) async {
    final response = await http.get(
      Uri.parse('$baseUrl/products'),
      headers: {
        'Accept-Language': locale,
        'X-Locale': locale,
        'Content-Type': 'application/json',
      },
    );
    
    if (response.statusCode == 200) {
      return json.decode(response.body);
    } else {
      throw Exception('فشل في تحميل البيانات');
    }
  }
}
```

### استخدام في React Native

```javascript
import AsyncStorage from '@react-native-async-storage/async-storage';

const ApiService = {
  async getProducts() {
    try {
      // الحصول على اللغة المحفوظة
      const savedLocale = await AsyncStorage.getItem('userLocale') || 'ar';
      
      const response = await fetch('/api/public/products', {
        method: 'GET',
        headers: {
          'Accept-Language': savedLocale,
          'X-Locale': savedLocale,
          'Content-Type': 'application/json',
        },
      });
      
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('خطأ في تحميل البيانات:', error);
    }
  }
};
```

## 📱 للموبايل Apps

### Android (Java)

```java
public class ApiService {
    private static final String BASE_URL = "https://your-domain.com/api/public/";
    
    public void getProducts(String locale) {
        OkHttpClient client = new OkHttpClient();
        
        Request request = new Request.Builder()
            .url(BASE_URL + "products")
            .addHeader("Accept-Language", locale)
            .addHeader("X-Locale", locale)
            .build();
            
        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String jsonData = response.body().string();
                // معالجة البيانات
            }
            
            @Override
            public void onFailure(Call call, IOException e) {
                // معالجة الخطأ
            }
        });
    }
}
```

### iOS (Swift)

```swift
import Foundation

class ApiService {
    static let baseURL = "https://your-domain.com/api/public/"
    
    static func getProducts(locale: String, completion: @escaping (Data?, Error?) -> Void) {
        guard let url = URL(string: baseURL + "products") else { return }
        
        var request = URLRequest(url: url)
        request.addValue(locale, forHTTPHeaderField: "Accept-Language")
        request.addValue(locale, forHTTPHeaderField: "X-Locale")
        request.addValue("application/json", forHTTPHeaderField: "Content-Type")
        
        URLSession.shared.dataTask(with: request) { data, response, error in
            completion(data, error)
        }.resume()
    }
}
```

## 🌐 اللغات المدعومة

| الكود | اللغة | الاسم الأصلي |
|-------|--------|-------------|
| `ar` | العربية | العربية |
| `en` | الإنجليزية | English |
| `tr` | التركية | Türkçe |
| `nl` | الهولندية | Nederlands |
| `be` | البلجيكية | Belgisch |

## ⚠️ ملاحظات مهمة

1. **الأولوية**: Custom Header > Accept-Language > URL Parameter > Cookie > Default
2. **الافتراضي**: إذا لم يتم تحديد لغة، سيتم استخدام العربية (`ar`)
3. **التراجع**: إذا لم تكن اللغة المدعومة موجودة، سيتم استخدام اللغة الافتراضية
4. **الحفظ**: اللغة المختارة تُحفظ في Cookie لمدة 30 يوم
5. **الاستجابة**: تحتوي كل استجابة على معلومات اللغة المستخدمة

## 🔍 اختبار API

```bash
# اختبار اللغات المختلفة
curl -H "X-Locale: ar" https://your-domain.com/api/public/products | jq '.locale'
curl -H "X-Locale: en" https://your-domain.com/api/public/products | jq '.locale'
curl -H "X-Locale: tr" https://your-domain.com/api/public/products | jq '.locale'

# اختبار Accept-Language
curl -H "Accept-Language: nl,en;q=0.9" https://your-domain.com/api/public/products | jq '.locale'

# اختبار URL Parameter
curl "https://your-domain.com/api/public/products?locale=be" | jq '.locale'
```
