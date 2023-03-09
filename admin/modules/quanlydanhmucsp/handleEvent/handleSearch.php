<?php
$mysqli = new mysqli("localhost", "root", "", "camera_shop");
//echo json_encode($_POST);

if (isset($_POST['searchInput'])) {
    $input = $_POST['searchInput'];
    $sql = "SELECT * FROM tbl_danhmuc WHERE ten_danhmuc LIKE '{$input}%'";
    $query = mysqli_query($mysqli, $sql);;
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
?>
<div class="products-row">
    <button class="cell-more-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-more-vertical">
            <circle cx="12" cy="12" r="1" />
            <circle cx="12" cy="5" r="1" />
            <circle cx="12" cy="19" r="1" />
        </svg>
    </button>
    <div class="product-cell col-1-5 thutu-danhmuc ">
        <p><?php echo $row['thutu'] ?></p>
    </div>
    <div class="product-cell col-2 category ">
        <p><?php echo $row['ten_danhmuc'] ?></p>
    </div>
    <div class="product-cell col status-cell">

        <?php
                    if ($row['category_status'] == 1) {
                    ?>
        <span class="status active">Kích hoạt</span>
        <?php
                    } else {
                    ?>
        <span class="status">Ẩn</span>
        <?php
                    }
                    ?>
    </div>
    <div class="product-cell col sales"><?php
                                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                    echo date('d/m/Y H:i', $row['category_created_time'])
                                                    ?>
    </div>
    <div class="product-cell col stock"><?php echo date('d/m/Y H:i', $row['category_last_updated']) ?>
    </div>
    <div class="product-cell col-1-8 detail">
        <button title="Xem chi tiết" class="detail-category" value="<?php echo $row['id_danhmuc'] ?>"><span>Xem
                chi tiết</span></button>
    </div>
    <div class="product-cell col-1 btn">
        <button title="Xóa" class="remove-category" value="<?php echo $row['id_danhmuc'] ?>"><i
                class="fa-solid fa-trash"></i></button>
    </div>
    <div class="product-cell col-1 btn">
        <button title="Sửa" class="edit-category" value="<?php echo $row['id_danhmuc'] ?>"><i
                class="fa-regular fa-pen-to-square"></i></button>
    </div>
</div>
<?php
        }
        ?>

<?php
    } else {
    ?>
<h1 class="empty-row">Không tìm thấy danh mục nào</h1>
<?php
    }
    ?>
<?php
}
?>