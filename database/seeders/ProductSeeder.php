<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elektronik = Category::where('name', 'Elektronik')->first();
        $ev_yasam = Category::where('name', 'Ev ve Yaşam')->first();
        $kitap = Category::where('name', 'Kitap')->first();
        $otomotiv_yapi_market = Category::where('name', 'Oto, Bahçe ve Yapı Market')->first();

        // Elektronik ürünler
        Product::create([
            'name' => 'İphone 12 Pro',
            'description' => 'Yüksek performanslı ve şık tasarıma sahip akıllı telefon.',
            'price' => 30500.00,
            'stock_quantity' => 50,
            'category_id' => $elektronik->id,
        ]);

        Product::create([
            'name' => 'Samsung Çamaşır Makinesi',
            'description' => 'Sessiz ve 12kg taşıma kapasitesi ile yorganlarınızı dahi yıkayabilirsiniz',
            'price' => 42300.90,
            'stock_quantity' => 30,
            'category_id' => $elektronik->id,
        ]);

        Product::create([
            'name' => 'Bosch Kurutma Makinesi',
            'description' => 'Sessiz ve 9kg taşıma kapasitesi ile kendinizi yormadan çamaşırlarınız kurulansın.',
            'price' => 47850.10,
            'stock_quantity' => 47,
            'category_id' => $elektronik->id,
        ]);

        Product::create([
            'name' => 'Arçelik Bulaşık Makinesi',
            'description' => 'Sessiz ve fazla taşıma kapasitesi ile kendinizi yormadan bulaşıklarınız ter temiz olsun.',
            'price' => 37500.10,
            'stock_quantity' => 82,
            'category_id' => $elektronik->id,
        ]);

        Product::create([
            'name' => 'Hp Taşınabilir Bilgisayar',
            'description' => '32GB Ram ve 512GB m2 SSD ile RTX3050 ekran kartıyla bütün oyunlarınızı kasmadan oynayın',
            'price' => 46510.99,
            'stock_quantity' => 81,
            'category_id' => $elektronik->id,
        ]);


        // Ev ve Yaşam ürünleri
        Product::create([
            'name' => 'Modern Kahve Masası',
            'description' => 'Minimalist tasarıma sahip, dayanıklı ahşap kahve masası.',
            'price' => 1500.00,
            'stock_quantity' => 30,
            'category_id' => $ev_yasam->id,
        ]);

        Product::create([
            'name' => 'Çamaşır Kurutma Askısı',
            'description' => 'Sağlam çelik telleri sayesinde uzun ömürlü Çamaşır Kurutma Askısı.',
            'price' => 580.00,
            'stock_quantity' => 60,
            'category_id' => $ev_yasam->id,
        ]);

        Product::create([
            'name' => 'PVC Masa Örtüsü',
            'description' => '90x120 ölçüsüne sahip bütün masalara uyum sağlayarak evinizi renklendirir',
            'price' => 117.00,
            'stock_quantity' =>100,
            'category_id' => $ev_yasam->id,
        ]);

        Product::create([
            'name' => 'Yüz Havlusu',
            'description' => '50x80 cm ölçüsü ile minimal pamuklu el-yüz havlusu.',
            'price' => 139.85,
            'stock_quantity' =>16,
            'category_id' => $ev_yasam->id,
        ]);

        Product::create([
            'name' => 'Tek Kişilik Çarşaf',
            'description' => '100x200 cm ölçülerine sahip lastikli tek kişilik pamuklu çarşaf.',
            'price' => 322.65,
            'stock_quantity' =>52,
            'category_id' => $ev_yasam->id,
        ]);


        // Kitap ürünleri
        Product::create([
            'name' => 'Bilim Kurgu Kitabı: Uzay Macerası',
            'description' => 'Sürükleyici bir uzay macerası romanı.',
            'price' => 120.00,
            'stock_quantity' => 100,
            'category_id' => $kitap->id,
        ]);

        Product::create([
            'name' => 'Gökyüzünde Nehirler var',
            'description' => 'Yüzyılları ve kıtaları birleştiren 
            göz kamaştırıcı bir roman.',
            'price' => 342.00,
            'stock_quantity' => 90,
            'category_id' => $kitap->id,
        ]);

        Product::create([
            'name' => 'Hayvan Masalı',
            'description' => 'Çocuklar için sıkılmadan okuyabileceği hayvanlar aleminin bulunduğu renkli masal.',
            'price' => 229.00,
            'stock_quantity' => 100,
            'category_id' => $kitap->id,
        ]);

        Product::create([
            'name' => 'KPSS Çıkmış Sorular',
            'description' => 'Son 10 yıl KPSS de çıkmış sorular.',
            'price' => 317.00,
            'stock_quantity' => 67,
            'category_id' => $kitap->id,
        ]);

        Product::create([
            'name' => 'Günümüz Şiirleri',
            'description' => 'Ülkemizin tanınan şiirlerini bir araya toplayan bu kitap okuyucularını uzak diyarlara götürmeyi hedeflemektedir.',
            'price' => 27.89,
            'stock_quantity' => 28,
            'category_id' => $kitap->id,
        ]);


        // Oto-Bahçe-Yapı Market Ürünleri
        Product::create([
            'name' => 'Araç için Şarjlı Oto Süpürge',
            'description' => '6000 mAh batarya ve 3 kademeli hız özellikleriyle kablosuz araç süpürgesi.',
            'price' => 987.10,
            'stock_quantity' => 50,
            'category_id' => $otomotiv_yapi_market->id,
        ]);

        Product::create([
            'name' => 'Oto Güneşlik Şemsiye Tip',
            'description' => 'Oto güneşlik şemsiye tipi sayesinde taşınılması ve saklanabilmesi çok kolay.',
            'price' => 349.10,
            'stock_quantity' => 70,
            'category_id' => $otomotiv_yapi_market->id,
        ]);

        Product::create([
            'name' => '12 Parça Oto Bakım Seti',
            'description' => 'Setin içeriğinde bulunan yıkama kovası, yıkama süngeri ve mikrofiber bez gibi yardımcı araçlar, temizlik işlemlerini kolaylaştırırken, oto şampuanı da aracınızı derinlemesine temizler.',
            'price' => 199.00,
            'stock_quantity' => 95,
            'category_id' => $otomotiv_yapi_market->id,
        ]);

        Product::create([
            'name' => 'Şarjlı Çay Toplama Makinesi',
            'description' => '4800 devir bıçak hızı ve 16 saat çalışma süresiyle kesintisiz çay toplayabilirsiniz.',
            'price' => 690.15,
            'stock_quantity' => 53,
            'category_id' => $otomotiv_yapi_market->id,
        ]);

        Product::create([
            'name' => 'WD 40 Sprey',
            'description' => 'WD 40 Spey ile güçlü Pas Sökücü ve Yağ Sökücü özelliğiyle tanışın',
            'price' => 298.80,
            'stock_quantity' => 40,
            'category_id' => $otomotiv_yapi_market->id,
        ]);
    }
}