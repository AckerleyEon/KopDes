UPDATE menu SET gambar='assets/images/espressosingle.png' WHERE id_menu=1;
UPDATE menu SET gambar='assets/images/longblack.png' WHERE id_menu=2;
UPDATE menu SET gambar='assets/images/americano.png' WHERE id_menu=3;
UPDATE menu SET gambar='assets/images/caffelatte.png' WHERE id_menu=4;
UPDATE menu SET gambar='assets/images/cappuccino.png' WHERE id_menu=5;
UPDATE menu SET gambar='assets/images/milkpresso.png' WHERE id_menu=6;
UPDATE menu SET gambar='assets/images/moccacino.png' WHERE id_menu=7;
UPDATE menu SET gambar='assets/images/arenlatte.png' WHERE id_menu=8;
UPDATE menu SET gambar='assets/images/bananalatte.png' WHERE id_menu=9;
UPDATE menu SET gambar='assets/images/caramellatte.png' WHERE id_menu=10;
UPDATE menu SET gambar='assets/images/hazelnutlatte.png' WHERE id_menu=11;
UPDATE menu SET gambar='assets/images/vanillalatte.png' WHERE id_menu=12;
UPDATE menu SET gambar='assets/images/rumlatte.png' WHERE id_menu=13;
UPDATE menu SET gambar='assets/images/baileyslatte.png' WHERE id_menu=14;
UPDATE menu SET gambar='assets/images/strawberrytea.png' WHERE id_menu=15;
UPDATE menu SET gambar='assets/images/carameltea.png' WHERE id_menu=16;
UPDATE menu SET gambar='assets/images/lemontea.png' WHERE id_menu=17;
UPDATE menu SET gambar='assets/images/milktea.png' WHERE id_menu=18;
UPDATE menu SET gambar='assets/images/rumtea.png' WHERE id_menu=19;
UPDATE menu SET gambar='assets/images/lycheetea.png' WHERE id_menu=20;
UPDATE menu SET gambar='assets/images/strawberryyakult.png' WHERE id_menu=21;
UPDATE menu SET gambar='assets/images/chocohazelnut.png' WHERE id_menu=22;
UPDATE menu SET gambar='assets/images/cookiesncream.png' WHERE id_menu=23;
UPDATE menu SET gambar='assets/images/lycheeyakult.png' WHERE id_menu=24;
UPDATE menu SET gambar='assets/images/mangoyakult.png' WHERE id_menu=25;
UPDATE menu SET gambar='assets/images/strawberrymilk.png' WHERE id_menu=26;
UPDATE menu SET gambar='assets/images/redvelvet.png' WHERE id_menu=27;
UPDATE menu SET gambar='assets/images/chocolatemilk.png' WHERE id_menu=28;
UPDATE menu SET gambar='assets/images/avocadomilk.png' WHERE id_menu=29;
UPDATE menu SET gambar='assets/images/matchamilk.png' WHERE id_menu=30;
UPDATE menu SET gambar='assets/images/taromilk.png' WHERE id_menu=31;
UPDATE menu SET gambar='assets/images/thaitea.png' WHERE id_menu=32;
UPDATE menu SET gambar='assets/images/vanillamilk.png' WHERE id_menu=33;
UPDATE menu SET gambar='assets/images/cocopandan.png' WHERE id_menu=34;
UPDATE menu SET gambar='assets/images/bluerose.png' WHERE id_menu=35;
UPDATE menu SET gambar='assets/images/mojito.png' WHERE id_menu=36;
UPDATE menu SET gambar='assets/images/melonsquash.png' WHERE id_menu=37;
UPDATE menu SET gambar='assets/images/nutrisarijeruk.png' WHERE id_menu=38;
UPDATE menu SET gambar='assets/images/susucoklat.png' WHERE id_menu=39;
UPDATE menu SET gambar='assets/images/susuputih.png' WHERE id_menu=40;
UPDATE menu SET gambar='assets/images/susujahe.png' WHERE id_menu=41;
UPDATE menu SET gambar='assets/images/teh.png' WHERE id_menu=42;
UPDATE menu SET gambar='assets/images/bengbengdrink.png' WHERE id_menu=43;
UPDATE menu SET gambar='assets/images/milo.png' WHERE id_menu=44;
UPDATE menu SET gambar='assets/images/gooddayfreeze.png' WHERE id_menu=45;
UPDATE menu SET gambar='assets/images/kopihitam.png' WHERE id_menu=46;
UPDATE menu SET gambar='assets/images/kopisusu.png' WHERE id_menu=47;
UPDATE menu SET gambar='assets/images/sususoda.png' WHERE id_menu=48;
UPDATE menu SET gambar='assets/images/joshua.png' WHERE id_menu=49;
UPDATE menu SET gambar='assets/images/nugget.png' WHERE id_menu=50;
UPDATE menu SET gambar='assets/images/sosis.png' WHERE id_menu=51;
UPDATE menu SET gambar='assets/images/kentanggoreng.png' WHERE id_menu=52;
UPDATE menu SET gambar='assets/images/mixplatter.png' WHERE id_menu=53;
UPDATE menu SET gambar='assets/images/tahuwalik.png' WHERE id_menu=54;
UPDATE menu SET gambar='assets/images/miegorengtelur.png' WHERE id_menu=55;
UPDATE menu SET gambar='assets/images/miekuahtelur.png' WHERE id_menu=56;
UPDATE menu SET gambar='assets/images/miegorengdouble.png' WHERE id_menu=57;

ALTER TABLE pesanan 
MODIFY status ENUM(
    'menunggu',
    'terkonfirmasi',
    'diproses',
    'selesai',
    'dibatalkan'
) NOT NULL DEFAULT 'menunggu';