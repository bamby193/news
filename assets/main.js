const CRAW_BONG_DA_24H = 1;
const CRAW_BONG_DA_COM = 2;


function addProcess(msg){
    let $process = $('#news-tool-process');
    $process.append(`<p class="text-success">${msg}</p>`);
}

function showError(msg){
    let process = $('#news-tool-process');
    process.append(`<p class="text-danger">${msg}</p>`)
}

function fetchData(url, cb, err){
    $.ajax({
        url: 'api/getHtml.php',
        timeout: 100000,
        type: "POST",
        data: {
            url: url
        },
        dataType: "json",
        success: function(response) {
            cb(response);
        },
        error: function (xhr, status) {
            err(xhr)
        }
    });
}

async function fetchAsyncData(url){
    return await $.ajax({
        url: 'api/getHtml.php',
        timeout: 100000,
        type: "POST",
        data: {
            url: url
        },
        dataType: "json"
    }).then(function(res) {
        return res;
    });
}

async function saveAsyncNews(data){
    return await $.ajax({
        url: 'index.php?controller=news&action=saveNews',
        timeout: 100000,
        type: "POST",
        data: data,
        dataType: "json"
    }).then(function(res) {
        return res.data;
    });
}

$(function(){
    $('#start-crawler').on('click', function(e){
        e.preventDefault();
        let $select = $('#news-url');
        let type = $select.val();
        let $this = $(this);
        $('#news-tool-process').empty();

        if(type){
            $option = $select.find('option:selected');
            let url = $option.data('url'); 
            let source = $option.data('source');

            $this.addClass('loading');
                $this.attr('disabled', true);
                addProcess('Bắt đầu kiểm tra và tải trang...');
                
                fetchData(url, async function(res){
                    if(res.status){
                        addProcess('Tải trang thành công...');
                        let { data } = res;
                        let $html = $(data);

                        if(type == CRAW_BONG_DA_24H){
                            await fetchBongDa24h($html, source);
                        }

                        if(type == CRAW_BONG_DA_COM){
                            await fetchBongDaCom($html, source);
                        }

                        $this.removeClass('loading');
                        $this.attr('disabled', false);
                    }
                }, function(err) {
                    showError(err.responseText)
                    $this.removeClass('loading');
                    $this.attr('disabled', false);
                });
        }else{
            alert('Vui lòng chọn nguồn tin tức.');
        }
    });

    // --- Fetch html and save db from BONGDA24H --- 
    async function fetchBongDa24h($html, source){
        let $posts = $html.find('.post-list');
        let data = [];

        addProcess('Bắt đầu bóc tách dữ liệu...');

        $posts.each(function(item, index){
            data.push({
                image: $(this).find('.article-image .image source.lazyload').data('srcset'), 
                title: $(this).find('.article-title').text(), 
                description: $(this).find('.article-summary').text(), 
                url: $(this).find('.article-title a').attr('href'),
                video: null,
                source
            });
        });

        addProcess('Bóc tách dữ liệu thành công...');
        addProcess('Bắt đầu lưu tin tức...');

        for (let index = 0; index < data.length; index++) {
            let element = data[index];
            element.url = `${source}${element.url}`;
            const news = await fetchAsyncData(element.url);
            if(news.status){
                const $newsHtml = $(news.data);
                element = {...element, detail: $.trim($newsHtml.find('.the-article-content').html())}
                let resData = await saveAsyncNews(element);
                if(resData){
                    addProcess(`Lưu thành công tin tức "${element.title}"`);
                    $('#news-tool-process').scrollTop($('#news-tool-process').height());
                }
            }   
        }

        addProcess(`Lưu tin tức hoàn thành!`);
        toastr.success('Lưu tin tức hoàn thành!');
        $('#news-tool-process').scrollTop($('#news-tool-process').height());
    }

    // --- Fetch html and save db from BONGDA PLUS --- 
    async function fetchBongDaCom($html, source){
        let $posts = $html.find('.list_top_news li');
        let data = [];

        addProcess('Bắt đầu bóc tách dữ liệu...');

        $posts.each(function(item, index){
            data.push({
                image: $(this).find('.thumbblock img').attr('src'), 
                title: $(this).find('.info_list_top_news .title_list_top_news').text(), 
                description: $(this).find('.info_list_top_news .sapo_news').text(), 
                url: $(this).find('.thumbblock').attr('href'),
                video: null,
                source
            });
        });

        addProcess('Bóc tách dữ liệu thành công...');
        addProcess('Bắt đầu lưu tin tức...');

        for (let index = 0; index < data.length; index++) {
            let element = data[index];
            const news = await fetchAsyncData(element.url);
            if(news.status){
                const $newsHtml = $(news.data);
                element = {...element, detail: $.trim($newsHtml.find('.news_details').html())}
                let resData = await saveAsyncNews(element);
                if(resData){
                    addProcess(`Lưu thành công tin tức "${element.title}"`);
                    $('#news-tool-process').scrollTop($('#news-tool-process').height());
                }
            }   
        }

        addProcess(`Lưu tin tức hoàn thành!`);
        toastr.success('Lưu tin tức hoàn thành!');
        $('#news-tool-process').scrollTop($('#news-tool-process').height());
    }

});


$(function(){
    $('.editor').trumbowyg();

    $('#popup-create-news').on('show.bs.modal', function(e){
        $('#form-create-news')[0].reset();
        $('.editor').trumbowyg('empty');
    });

    $('.remove-news').on('click', function(e){
        e.preventDefault();
        let $this = $(this);
        let url = $this.attr('href');

        $this.closest('tr').fadeOut(500, function(){
            $(this).remove();
            $.ajax({
                url: url,
                timeout: 100000,
                type: "DELETE",
                data: {},
                dataType: "json",
                success: function(res) {
                    if(res.data){
                        toastr.success(res.data);
                    }
                },
                error: function (xhr, status) {
                    console.error(xhr.responseText);
                }
            });
        })
    });

    $('#form-create-news').on('submit', function(e){
        e.preventDefault();
        let $form = $(this);
        let url = $form.attr('action');
        let formData = $form.serializeArray();

        $form.find('button').attr('disabled', true);
        $form.find('.btn-loading').addClass('loading');

        $.ajax({
            url: url,
            timeout: 100000,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(res) {
                if(res.data){
                    toastr.success('Thêm mới tin tức thành công');
                    setTimeout(() => location.reload(), 800);
                }
            },
            error: function (xhr, status) {
                console.error(xhr.responseText);
                $form.find('button').attr('disabled', false);
                $form.find('.btn-loading').removeClass('loading');
            }
        });
    })
})