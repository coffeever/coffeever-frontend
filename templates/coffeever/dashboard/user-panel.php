<?php
defined('INDEX') or die();
global $actionResult;
$pageData = $_SESSION['subscriberObj'];
$orders = makeRequest('getList', ['subscriberId'=>$pageData['_id']], ['collection' => 'orders']);
debugPrint($pageData);
?>
<div class="container content-area">
    <div class="site-account w100">
        <div class="title-wrapper text-center">
            <ol class="breadcrumbs d-flex align-items-center justify-content-center" itemscope
                itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="/">
                        <span itemprop="name">Anasayfa</span><span class="delimiter">/</span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="https://rt-barberry.myshopify.com/hesap/kullanici-paneli">
                        <span itemprop="name">Hesabım</span>
                    </a>
                    <meta itemprop="position" content="2"/>
                </li>
            </ol>
            <h1 class="page-title">Hesabım</h1>
            <div class="term-description">
                <p>Hoşgeldiniz, <?php echo $_SESSION['subscriberObj']['name']; ?><br><a href="/hesap/cikis-yap">Çıkış Yap</a></p>
            </div>
            <div class="message-box alert alert-<?php echo isset($actionResult['status']) && $actionResult['status'] ? 'success' : 'danger' ?> fade show" role="alert" style="display: <?php echo isset($actionResult) && !empty($actionResult['message']) ? 'block' : 'none'; ?>">
                <?php echo isset($actionResult['message']) ? $actionResult['message'] : ''; ?>
            </div>
        </div>

        <div class="row row-60">
            <div class="col-sm-12 col-lg-4">
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'gosterge-paneli')" id="defaultOpen">Gösterge Paneli
                    </button>
                    <button class="tablinks" onclick="openTab(event, 'siparislerim')">Siparişlerim</button>
                    <button class="tablinks" onclick="openTab(event, 'adreslerim')">Adres Defteri</button>
                    <button class="tablinks" onclick="openTab(event, 'hesap-detaylari')">Hesap Detayları</button>
                    <button class="tablinks" onclick="openTab(event, 'parola-degistir')">Parolamı Değiştir</button>
                    <button class="tablinks" onclick="window.location.href='/hesap/cikis-yap'">Çıkış Yap</button>
                </div>
            </div>
            <div class="col-sm-12 col-lg-8">
                <div id="gosterge-paneli" class="tabcontent">
                    <h2 class="page-subtitle">Gösterge Paneli</h2>
                    <p>London is the capital city of England.</p>
                </div>
                <div id="siparislerim" class="tabcontent">
                    <h2 class="page-subtitle">Siparişlerim</h2>
                    <?php if (isset($orders) && !empty($orders)): ?>
                    <div class="order-wrapper">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th>Sipariş</th>
                                <th>Tarih</th>
                                <th>Durum</th>
                                <th>Toplam Tutar</th>
                                <th>Görüntüle</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orders as $key => $order): ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo formatDateTime($order['createdAt']); ?></td>
                                <td><?php echo getOrderStateString($order['state']); ?></td>
                                <td><?php echo $order['total']; ?> TL</td>
                                <td><a href="/siparis-detay/<?php echo $order['orderNumber']; ?>" class="check-btn sqr-btn ">Detay</a></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p>Siparişiniz bulunmamaktadır.</p>
                    <?php endif; ?>
                </div>
                <div id="adreslerim" class="tabcontent">
                    <h2 class="page-subtitle">Adres Defteri</h2>
                    <?php if (isset($pageData['addresses']) && !empty($pageData['addresses'])): ?>
                        <div class="row">
                            <?php foreach ($pageData['addresses'] as $address): ?>
                                <div class="col-12 col-lg-4">
                                    <div class="address">
                                        <div class="text-center">
                                            <h3><a><?php echo $address['title']; ?></a></h3>
                                            <p><a><?php echo $address['name'] . '</a> <a>' . $address['surname']; ?></a><br>
                                                <a><?php echo $address['phone']; ?></a><br>
                                                <a><?php echo $address['district']; ?></a><br>
                                                <a><?php echo $address['address']; ?></a><br>
                                                <a><?php echo $address['city'] . '</a>/<a>' . $address['county']; ?></a><br>
                                            </p>
                                            <p>
                                                <button type="button" class="button address-edit-toggle" data-id="<?php echo $address['id']; ?>">Düzenle</button>
                                                <button type="button" class="button address-delete" data-id="<?php echo $address['id']; ?>" data-confirm-message="Bu adresi silmek istediğinizden emin misiniz?">Sil</button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <a href="#" class="btn btn-primary" id="addAddress">Adres Ekle</a>
                </div>
                <div id="parola-degistir" class="tabcontent">
                    <h2 class="page-subtitle">Parolamı Değiştir</h2>
                    <form name="renew-password-form" id="renewPasswordForm" method="POST" action="">
                        <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
                        <input type="hidden" name="action" value="change-password">
                        <input type="hidden" name="subscriberId" value="<?php echo $_SESSION['subscriberObj']['_id']; ?>">
                        <div class="form-group">
                            <input type="password" name="old-password" placeholder="Mevcut Parolanız" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="new-password" placeholder="Yeni Parolanız" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="new-password2" placeholder="Yeni Parolanız Tekrar" required>
                        </div>
                        <button type="submit" name="process" class="btn btn-primary w100">Şifrenizi sıfırlayın</button>
                    </form>
                </div>
                <div id="hesap-detaylari" class="tabcontent">
                    <h2 class="page-subtitle">Hesap Detayları</h2>
                    <form method="post" action="" accept-charset="UTF-8">
                        <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
                        <input type="hidden" name="action" value="update_profile">
                        <input type="hidden" name="action-detail" value="update_profile">
                        <div class="form-group">
                            <label for="AddressAddress1New">Adınız</label>
                            <input type="text"  name="name" value="<?php echo $pageData['name']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="AddressAddress2New">Soyadınız</label>
                            <input type="text" name="surname" value="<?php echo $pageData['surname']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="AddressCityNew">Email Adresiniz</label>
                            <input type="text" name="email" autocapitalize="characters" value="<?php echo $pageData['email']; ?>"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w100">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-add-address" class="modal modal-add-address">
    <form action="" method="post">
        <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
        <input type="hidden" name="action" value="add_address">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Ad*</label>
                    <input type="text" id="name" name="name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="surname">Soyad*</label>
                    <input type="text" id="surname" name="surname" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="city">İl*</label>
                    <input type="text" id="city" name="city" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="county">İlçe*</label>
                    <input type="text" id="county" name="county" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="district">Mahalle*</label>
                    <input type="text" id="district" name="district" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Telefon*</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">Adres*</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="title">Adres Başlığı*</label>
                    <input type="text" id="title" name="title" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Ekle</button>
        </div>
    </form>
</div>
<div id="modal-update-address" class="modal modal-update-address">
    <form action="" method="post">
        <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
        <input type="hidden" name="action" value="update_address">
        <input type="hidden" name="addressId" value="" id="addressId">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Ad*</label>
                    <input type="text" id="name" name="name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="surname">Soyad*</label>
                    <input type="text" id="surname" name="surname" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="city">İl*</label>
                    <input type="text" id="city" name="city" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="county">İlçe*</label>
                    <input type="text" id="county" name="county" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="district">Mahalle*</label>
                    <input type="text" id="district" name="district" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Telefon*</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">Adres*</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="title">Adres Başlığı*</label>
                    <input type="text" id="title" name="title" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </div>
    </form>
</div>
<div id="modal-delete-address" class="modal modal-delete-address">
    <a>Bu adresi silmek istediğinizden emin misiniz?</a>
    <form action="" method="post">
        <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
        <input type="hidden" name="action" value="delete_address">
        <input type="hidden" name="addressId" value="" id="addressId">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Sil</button>
        </div>
    </form>
</div>
<?php ob_start(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<?php printOnFooter(ob_get_contents()); ?>
<?php ob_end_clean(); ?>