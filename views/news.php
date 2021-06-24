<div class="news py-4">
        <div class="container">
          <div class="table-wrapper">
            <div class="news-tool text-right mb-4">
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#popup-create-news" data-backdrop="static">
                    <i class="fas fa-plus mr-1"></i>
                    Thêm mới
                </button>
            </div>
            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th class="no-wrap">Hình ảnh</th>
                        <th class="no-wrap">Tiêu đề</th>
                        <th class="no-wrap">Mô tả</th>
                        <th class="no-wrap">Nguồn</th>
                        <th class="no-wrap"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($listsNews as $row) {
                            echo "<tr>
                                <td><img src='{$row['image']}' class='news-image'/></td>
                                <td><a target='_blank' href='{$row['url']}'>{$row['title']}</a></td>
                                <td>{$row['description']}</td>
                                <td><a target='_blank' href='{$row['source']}'>{$row['source']}</a></td>
                                <td><a href='index.php?controller=news&action=delete&id={$row['id']}' class='text-danger remove-news px-2'>Xoá</a></td>
                            </tr>";
                        }
                    ?>
                <tbody>
            </table>
          </div>
        </div>
    </div>

    <?php include('modal.php')?>