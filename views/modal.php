<div class="modal fade" id="popup-create-news" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm mới tin tức</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-create-news" action="index.php?controller=news&action=saveNews" method="POST">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input name="title" class="form-control" placeholder="Tiêu đề bài viết" required />
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Mô tả bài viết"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Chi tiết</label>
                        <textarea name="detail" class="form-control editor" rows="4" placeholder="Chi tiết bài viết"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Link ảnh</label>
                        <input name="image" class="form-control" placeholder="Link ảnh" required />
                    </div>

                    <div class="form-group">
                        <label>Link video (Nếu có)</label>
                        <input name="video" class="form-control" placeholder="Link video (Nếu có)" />
                    </div>

                    <div class="form-group">
                        <label>Đường dẫn tin tức</label>
                        <input name="url" class="form-control" placeholder="Đường dẫn tin tức" required />
                    </div>

                    <div class="form-group">
                        <label>Nguồn</label>
                        <input name="source" class="form-control" placeholder="Nguồn tin" required />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Đóng</button>
                    <button class="btn btn-sm btn-success btn-loading">
                        <i class="fas fa-circle-notch fa-spin"></i>
                        <span>Xác nhận</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>