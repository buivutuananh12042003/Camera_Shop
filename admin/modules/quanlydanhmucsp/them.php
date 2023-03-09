<div class="model__add-new-container">
    <div class="model-close-btn"><i class="fa-solid fa-xmark"></i></div>
    <form id="form-add-new-category" method="POST" enctype="multipart/form-data">
        <div class="model__add-new">
            <h3>Thêm danh mục</h3>
            <div class="model__content">
                <label class="col-2">Tên danh mục: </label>
                <input type="text" class="tendanhmuc" val="" name="tendanhmuc">
                <span class="errorName" style="color:red;"></span>
            </div>
            <div class="model__content">
                <label class="col-2">Thứ tự danh mục: </label>
                <input type="number" name="thutu" class="thutu">
                <span class="errorThutu" style="color:red;"></span>
            </div>
            <div class="model__content">
                <label class="col-2">Trạng thái: </label>
                <select name="trangthai" class="trangthai">
                    <option value="1">Kích hoạt</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
            <div class="model__content">
                <label>Chi tiết danh mục: </label>
                <!-- The toolbar will be rendered in this container. -->
                <div id="toolbar-container"></div>

                <!-- This container will become the editable. -->
                <div name="category_detail" id="editor">
                </div>
                <span class="errorDetail" style="color:red;"></span>
            </div>
            <button id="themdanhmuc">Thêm danh mục sản phẩm</button>
            <span class="errorExist" style="color:red;"></span>
        </div>
    </form>
</div>



<script>
    // CKEditor 5
    var myEditor;
    DecoupledEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            const toolbarContainer = document.querySelector('#toolbar-container');
            toolbarContainer.appendChild(editor.ui.view.toolbar.element);
            myEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    $(document).ready(() => {
        // View data
        function view_data() {
            $.post('http://localhost:3000/admin/modules/quanlydanhmucsp/handleEvent/listCategoryData.php',
                function(
                    data) {
                    console.log(data)
                    $('#load_category_data').html(data)
                })
        }
        // Handle add new category
        $('#themdanhmuc').click((e) => {
            e.preventDefault();
            var tendanhmuc = $('.tendanhmuc').val();
            var thutu = $('.thutu').val();
            var trangthai = $('.trangthai').val();

            let errors = {
                nameError: '',
                thuTuError: '',
                detailError: ''
            }

            // Validate category name
            if (tendanhmuc.length === 0) {
                errors.nameError = 'Tên danh mục không được để trống'
                swal("Vui lòng nhập lại", errors.nameError, "error");
                $('.tendanhmuc').val('')
            } else {
                errors.nameError = '';
            }

            // Validate thu tu
            if (thutu.length === 0) {
                errors.thuTuError = 'Thứ tự không được để trống'
                swal("Vui lòng nhập lại", errors.thuTuError, "error");
                $('.thutu').val('');
            } else if (thutu <= 0) {
                errors.thuTuError = 'Thứ tự phải lớn hơn 1'
                swal("Vui lòng nhập lại", errors.thuTuError, "error");
                $('.thutu').val('');
            } else {
                errors.thuTuError = '';
            }

            // Validate category detail
            if (myEditor.getData().length === 0) {
                errors.detailError = 'Nội dung danh mục không được để trống'
                swal("Vui lòng nhập lại", errors.detailError, "error");
            } else {
                errors.detailError = ''
                $('.errorDetail').text(errors.detailError);
            }

            if (errors.detailError === '' && errors.thuTuError === '' && errors.nameError === '') {
                $.ajax({
                    url: "http://localhost:3000/admin/modules/quanlydanhmucsp/handleEvent/handleAddCategory.php",
                    data: {
                        tendanhmuc: tendanhmuc,
                        thutu: thutu,
                        trangthai: trangthai,
                        category_detail: myEditor.getData(),
                    },
                    dataType: 'json',
                    method: "post",
                    cache: true,
                    success: function(data) {

                        if (data.existName === 1) {
                            swal("Vui lòng nhập lại", 'Danh mục đã tồn tại', "error");
                            $('.tendanhmuc').val('')
                        }
                        if (data.existThutu === 1) {
                            swal("Vui lòng nhập lại", 'Thứ tự đã tồn tại', "error");
                            $('.thutu').val('');
                        }

                        if (data.existThutu === 0 && data.existName === 0) {
                            $('.tendanhmuc').val('')
                            $('.thutu').val('');
                            swal("OK!", "Thêm thành công", "success");
                            view_data();
                        }
                    }
                })
            }

        })
    })
</script>