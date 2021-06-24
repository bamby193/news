<div class="news py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="news-tool"> 
                        <div class="d-flex flex-column align-items-center mb-2">
                            <img src="assets/images/profile.png" alt="Đồng bộ tin tức từ nguồn khác"/>
                            <h5 class="news-tool-title">Đồng bộ tin tức từ nguồn khác</h5>
                        </div>
                        <div class="news-tool-select">
                            <select class="form-control" id="news-url" require>
                                <option value="">Vui lòng chọn nguồn</option>
                                <?php
                                    foreach (LINKS_NEWS as $key => $value) {
                                        $title = $value['title'];
                                        $source = $value['source'];
                                        echo "<option value='$key' data-url='$source' data-source='$title'>$title</option>";
                                    }
                                ?> 
                            </select>
                            <button class="btn btn-success btn-loading ml-2" id="start-crawler">
                                <i class="fas fa-circle-notch fa-spin"></i>
                                <span>Bắt đầu</span>
                            </button>
                        </div>
                        <div class="news-tool-process" id="news-tool-process"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
