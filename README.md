Proje isim: E-Ticaret API (Laravel & PostgreSQL)

Üstünde çalıştığım bu proje de PHP Laravel ve PostegreSQL kullanarak geliştirdim.

Kullandığım sürümler ise;
-> PHP 8.2
-> Laravel 12.0
-> Databese: PostegreSql 17
-> Kimlik Doğrulama Aşamalarını ise JWT 

Bu proje kullanıcı yönetimi, ürün katalogu, sepet ve sipariş yönetimi gibi temel e-ticaret işlevlerini sağlamaktadır. 
RESTful API'leri kullanarak postman ile gönderdiğimiz requestler'le istenilen sonuçlara ulaşarak gerekli işlemler sağlanmaktadır.



----> Kurulum <----

1. Projeyi Klonlama:
git clone https://github.com/furkanabali/eticaret-api
cd eticaret-api 

2. Bağımlılıkları Yüklemek için:
composer install

3. Ortam Dosyasını Yapılandırmak için:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ticaret
DB_USERNAME=postgres
DB_PASSWORD=3417

4. JWT Gizli Anahtarını Oluşturmak için:
php artisan jwt:secret

5. Veritabanını Oluşturma ve Veri Eklemek için:
php artisan migrate:fresh --seed

6. Başlatmak için ise:
php artisan serve


----> Veritabanı Kurulumu <----

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ticaret
DB_USERNAME=postgres
DB_PASSWORD=3417

env. dosyamda bulunan db giriş bilgileri yukarıdadır ve ek olarak terminalde;
php artisan migrate --seed  
yazarak oluşturmuş olduğum migration tablolarını ve seed bilgileri ticaret isimli db'e yani postegresql'e aktaracaktır.




----> API Endpoint'leri <----

1. Kullanıcı Yönetimi:


Method   ---   Endpoint   ---   Açıklama   ---   Yetkilendirme

POST       /api/register     Yeni kullanıcı kaydı           Public
POST       /api/login        Kullanıcı girişi               Public
GET        /api/profile    Kullanıcı profilini görüntüleme    JWT
PUT        /api/profile    Kullanıcı profilini güncelle       JWT




2. Kategori Yönetimi:


Method   ---   Endpoint   ---   Açıklama   ---   Yetkilendirme

GET        /api/categories      Tüm kategorileri listele        Public
POST       /api/categories         Yeni kategori oluştur        Sadece Admin
PUT        /api/categories/{id}      Kategoriyi güncelle        Sadece Admin
DELETE     /api/categories/{id}      Kategoriyi sil             Sadece Admin




3. Ürün Yönetimi:


Method   ---   Endpoint   ---   Açıklama   ---   Yetkilendirme

GET       /api/products        Ürünleri listele     Public
GET       /api/products/{id}    Tek ürün detayı     Public
POST      /api/products          Yeni ürün ekle     Sadece Admin
PUT       /api/products/{id}     Ürünü güncelle     Sadece Admin
DELETE    /api/products/{id}          Ürünü sil     Sadece Admin




4. Sepet Yönetimi:


Method   ---   Endpoint   ---   Açıklama   ---   Yetkilendirme

GET            /api/cart           Sepeti görüntüle     JWT 
POST       /api/cart/add           Sepete ürün ekle     JWT 
PUT     /api/cart/update    Ürün miktarını güncelle     JWT 
DELETE  /api/cart/remove/{id}   Sepetten ürün çıkar     JWT 
DELETE  /api/cart/clear               Sepeti boşalt     JWT 




5. Sipariş Yönetimi:


Method   ---   Endpoint   ---   Açıklama   ---   Yetkilendirme

POST       /api/orders             Sepeti siparişe dönüştür      JWT 
GET        /api/orders   Kullanıcının siparişlerini listele      JWT 
GET        /api/orders/{id}      Sipariş detayını görüntüle      JWT






----> Örnek request/response'lar <----

1. POST - http://127.0.0.1:8000/api/login

request:

{
  "email": "admin@test.com",
  "password": "admin123"
}


bu işlem sonucu ise aldığım response:

{
    "success": true,
    "message": "Giriş başarılı.",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzU2NjYyNjc5LCJleHAiOjE3NTY2NjYyNzksIm5iZiI6MTc1NjY2MjY3OSwianRpIjoiWGtFWkpEdzlFNUhabkIwRiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Nk0xnJZudBExHcO6vEJxVGicFeuj8SwzMR8o3eyuLfQ",
        "token_type": "bearer",
        "expires_in": 3600
    }
}



2. GET - http://127.0.0.1:8000/api/categories

response:

{
    "success": true,
    "message": "Kategoriler başarıyla listelendi.",
    "data": [
        {
            "id": 1,
            "name": "Elektronik",
            "description": "Cep telefonları, bilgisayarlar ve diğer elektronik cihazlar.",
            "created_at": "2025-08-30T14:39:30.000000Z",
            "updated_at": "2025-08-30T14:39:30.000000Z"
        },
        {
            "id": 2,
            "name": "Ev ve Yaşam",
            "description": "Ev dekorasyon ürünleri, mobilyalar ve mutfak gereçleri.",
            "created_at": "2025-08-30T14:39:30.000000Z",
            "updated_at": "2025-08-30T14:39:30.000000Z"
        },
        {
            "id": 3,
            "name": "Kitap",
            "description": "Farklı türlerde romanlar, ders kitapları ve dergiler.",
            "created_at": "2025-08-30T14:39:30.000000Z",
            "updated_at": "2025-08-30T14:39:30.000000Z"
        },
        {
            "id": 4,
            "name": "Oto, Bahçe ve Yapı Market",
            "description": "Otomotiv ürünleri, bahçe gereçleri ve yapı malzeme ürünleri.",
            "created_at": "2025-08-30T14:39:30.000000Z",
            "updated_at": "2025-08-30T14:39:30.000000Z"
        }
    ]
}


3. GET - http://127.0.0.1:8000/api/products

response:

{
    "success": true,
    "message": "Ürünler başarıyla listelendi.",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 2,
                "name": "Samsung Çamaşır Makinesi",
                "description": "Sessiz ve 12kg taşıma kapasitesi ile yorganlarınızı dahi yıkayabilirsiniz",
                "price": "42300.90",
                "stock_quantity": 30,
                "category_id": 1,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 1,
                    "name": "Elektronik",
                    "description": "Cep telefonları, bilgisayarlar ve diğer elektronik cihazlar.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 3,
                "name": "Bosch Kurutma Makinesi",
                "description": "Sessiz ve 9kg taşıma kapasitesi ile kendinizi yormadan çamaşırlarınız kurulansın.",
                "price": "47850.10",
                "stock_quantity": 47,
                "category_id": 1,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 1,
                    "name": "Elektronik",
                    "description": "Cep telefonları, bilgisayarlar ve diğer elektronik cihazlar.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 4,
                "name": "Arçelik Bulaşık Makinesi",
                "description": "Sessiz ve fazla taşıma kapasitesi ile kendinizi yormadan bulaşıklarınız ter temiz olsun.",
                "price": "37500.10",
                "stock_quantity": 82,
                "category_id": 1,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 1,
                    "name": "Elektronik",
                    "description": "Cep telefonları, bilgisayarlar ve diğer elektronik cihazlar.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 5,
                "name": "Hp Taşınabilir Bilgisayar",
                "description": "32GB Ram ve 512GB m2 SSD ile RTX3050 ekran kartıyla bütün oyunlarınızı kasmadan oynayın",
                "price": "46510.99",
                "stock_quantity": 81,
                "category_id": 1,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 1,
                    "name": "Elektronik",
                    "description": "Cep telefonları, bilgisayarlar ve diğer elektronik cihazlar.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 6,
                "name": "Modern Kahve Masası",
                "description": "Minimalist tasarıma sahip, dayanıklı ahşap kahve masası.",
                "price": "1500.00",
                "stock_quantity": 30,
                "category_id": 2,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 2,
                    "name": "Ev ve Yaşam",
                    "description": "Ev dekorasyon ürünleri, mobilyalar ve mutfak gereçleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 7,
                "name": "Çamaşır Kurutma Askısı",
                "description": "Sağlam çelik telleri sayesinde uzun ömürlü Çamaşır Kurutma Askısı.",
                "price": "580.00",
                "stock_quantity": 60,
                "category_id": 2,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 2,
                    "name": "Ev ve Yaşam",
                    "description": "Ev dekorasyon ürünleri, mobilyalar ve mutfak gereçleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 9,
                "name": "Yüz Havlusu",
                "description": "50x80 cm ölçüsü ile minimal pamuklu el-yüz havlusu.",
                "price": "139.85",
                "stock_quantity": 16,
                "category_id": 2,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 2,
                    "name": "Ev ve Yaşam",
                    "description": "Ev dekorasyon ürünleri, mobilyalar ve mutfak gereçleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 10,
                "name": "Tek Kişilik Çarşaf",
                "description": "100x200 cm ölçülerine sahip lastikli tek kişilik pamuklu çarşaf.",
                "price": "322.65",
                "stock_quantity": 52,
                "category_id": 2,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 2,
                    "name": "Ev ve Yaşam",
                    "description": "Ev dekorasyon ürünleri, mobilyalar ve mutfak gereçleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 11,
                "name": "Bilim Kurgu Kitabı: Uzay Macerası",
                "description": "Sürükleyici bir uzay macerası romanı.",
                "price": "120.00",
                "stock_quantity": 100,
                "category_id": 3,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 3,
                    "name": "Kitap",
                    "description": "Farklı türlerde romanlar, ders kitapları ve dergiler.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 12,
                "name": "Gökyüzünde Nehirler var",
                "description": "Yüzyılları ve kıtaları birleştiren \n            göz kamaştırıcı bir roman.",
                "price": "342.00",
                "stock_quantity": 90,
                "category_id": 3,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 3,
                    "name": "Kitap",
                    "description": "Farklı türlerde romanlar, ders kitapları ve dergiler.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 13,
                "name": "Hayvan Masalı",
                "description": "Çocuklar için sıkılmadan okuyabileceği hayvanlar aleminin bulunduğu renkli masal.",
                "price": "229.00",
                "stock_quantity": 100,
                "category_id": 3,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 3,
                    "name": "Kitap",
                    "description": "Farklı türlerde romanlar, ders kitapları ve dergiler.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 14,
                "name": "KPSS Çıkmış Sorular",
                "description": "Son 10 yıl KPSS de çıkmış sorular.",
                "price": "317.00",
                "stock_quantity": 67,
                "category_id": 3,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 3,
                    "name": "Kitap",
                    "description": "Farklı türlerde romanlar, ders kitapları ve dergiler.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 15,
                "name": "Günümüz Şiirleri",
                "description": "Ülkemizin tanınan şiirlerini bir araya toplayan bu kitap okuyucularını uzak diyarlara götürmeyi hedeflemektedir.",
                "price": "27.89",
                "stock_quantity": 28,
                "category_id": 3,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 3,
                    "name": "Kitap",
                    "description": "Farklı türlerde romanlar, ders kitapları ve dergiler.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 16,
                "name": "Araç için Şarjlı Oto Süpürge",
                "description": "6000 mAh batarya ve 3 kademeli hız özellikleriyle kablosuz araç süpürgesi.",
                "price": "987.10",
                "stock_quantity": 50,
                "category_id": 4,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 4,
                    "name": "Oto, Bahçe ve Yapı Market",
                    "description": "Otomotiv ürünleri, bahçe gereçleri ve yapı malzeme ürünleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 17,
                "name": "Oto Güneşlik Şemsiye Tip",
                "description": "Oto güneşlik şemsiye tipi sayesinde taşınılması ve saklanabilmesi çok kolay.",
                "price": "349.10",
                "stock_quantity": 70,
                "category_id": 4,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 4,
                    "name": "Oto, Bahçe ve Yapı Market",
                    "description": "Otomotiv ürünleri, bahçe gereçleri ve yapı malzeme ürünleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 18,
                "name": "12 Parça Oto Bakım Seti",
                "description": "Setin içeriğinde bulunan yıkama kovası, yıkama süngeri ve mikrofiber bez gibi yardımcı araçlar, temizlik işlemlerini kolaylaştırırken, oto şampuanı da aracınızı derinlemesine temizler.",
                "price": "199.00",
                "stock_quantity": 95,
                "category_id": 4,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 4,
                    "name": "Oto, Bahçe ve Yapı Market",
                    "description": "Otomotiv ürünleri, bahçe gereçleri ve yapı malzeme ürünleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 19,
                "name": "Şarjlı Çay Toplama Makinesi",
                "description": "4800 devir bıçak hızı ve 16 saat çalışma süresiyle kesintisiz çay toplayabilirsiniz.",
                "price": "690.15",
                "stock_quantity": 53,
                "category_id": 4,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T14:39:30.000000Z",
                "category": {
                    "id": 4,
                    "name": "Oto, Bahçe ve Yapı Market",
                    "description": "Otomotiv ürünleri, bahçe gereçleri ve yapı malzeme ürünleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 1,
                "name": "İphone 12 Pro",
                "description": "Yüksek performanslı ve şık tasarıma sahip akıllı telefon.",
                "price": "30500.00",
                "stock_quantity": 48,
                "category_id": 1,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T15:17:51.000000Z",
                "category": {
                    "id": 1,
                    "name": "Elektronik",
                    "description": "Cep telefonları, bilgisayarlar ve diğer elektronik cihazlar.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 8,
                "name": "Masa Örtüsü",
                "description": "90x120 ölçüsüne sahip bütün masalara uyum sağlayarak evinizi renklendirir",
                "price": "150.00",
                "stock_quantity": 200,
                "category_id": 2,
                "created_at": "2025-08-30T14:39:30.000000Z",
                "updated_at": "2025-08-30T16:20:04.000000Z",
                "category": {
                    "id": 2,
                    "name": "Ev ve Yaşam",
                    "description": "Ev dekorasyon ürünleri, mobilyalar ve mutfak gereçleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            },
            {
                "id": 22,
                "name": "WD 40 Sprey",
                "description": "WD 40 Spey ile güçlü Pas Sökücü ve Yağ Sökücü özelliğiyle tanışın.",
                "price": "298.80",
                "stock_quantity": 40,
                "category_id": 4,
                "created_at": "2025-08-31T13:16:03.000000Z",
                "updated_at": "2025-08-31T13:16:03.000000Z",
                "category": {
                    "id": 4,
                    "name": "Oto, Bahçe ve Yapı Market",
                    "description": "Otomotiv ürünleri, bahçe gereçleri ve yapı malzeme ürünleri.",
                    "created_at": "2025-08-30T14:39:30.000000Z",
                    "updated_at": "2025-08-30T14:39:30.000000Z"
                }
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/products?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://127.0.0.1:8000/api/products?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/products?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://127.0.0.1:8000/api/products",
        "per_page": 20,
        "prev_page_url": null,
        "to": 20,
        "total": 20
    }
}





----> Test Kullanıcı Bilgileri <----

-->  Admin Kullanıcı:
Email: admin@test.com
Şifre: admin123

-->  Normal Kullanıcı:
Email: user@test.com
Şifre: user123

--> Ek olarak postman API isteklerini kontrol etmek için oluşturmuş olduğum kullanıcı:
Email: furkan@test.com
Şifre: furkan123