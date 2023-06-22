# Mới sửa

## Slick

```bash
$('.banner').slick({

                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                speed: 500,
                fade: false, ->chuyển animation sang slide
                dots: true,
                cssEase: 'linear',
                autoplay: true,
                autoplaySpeed: 3000,
                prevArrow: '<div class="slick-prev"><i class="fa-solid fa-chevron-left"></i></div>',
                nextArrow: '<div class="slick-next"><i class="fa-solid fa-chevron-right"></i></div>'
            });

//thêm nếu xoá fade: true
.banner__wrapper{
        position: relative;
```
```bash
$('.content__fill-list').slick({
                dots: true,
                infinite: true,  infinity slide
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
                prevArrow: '<div class="slick-prev"><i class="fa-solid fa-chevron-left"></i></div>',
                nextArrow: '<div class="slick-next"><i class="fa-solid fa-chevron-right"></i></div>',
```
## Tool tip

```bash
//home.blade.php line 53
<div class="tech__box">
    <div class="icon__wrapper">
        <div class="icon__main">
            <i class="fa-brands fa-php"></i>
            <span class="tool__tip">PHP là một ngôn ngữ lập trình đã từng rất phổ biến, được dự đoán chết từ 10 năm trước nhưng bây giờ nó vẫn sống</span>
        </div>
    </div>
    <div class="icon__wrapper">
        <div class="icon__main">
            <i class="fa-brands fa-node-js"></i>
            <span class="tool__tip">JS là một trong những ngôn ngữ lập trình phổ biến nhất trong phát triển ứng dụng web</span>
        </div>
    </div>
    <div class="icon__wrapper">
        <div class="icon__main">    
            <i class="fa-brands fa-react"></i>
            <span class="tool__tip">ReactJS - một thư viện front-end JS được phát triển bởi Facebook</span>
        </div>
    </div>
    <div class="icon__wrapper">
        <div class="icon__main">
            <i class="fa-brands fa-css3-alt"></i>
            <span class="tool__tip">CSS - ngôn ngữ dùng để style tài liệu HTML</span>
        </div>
    </div>
</div>
//home.scss line 19
.icon__main {
        position: relative;
    }
    .tool__tip {
        width: 120px;
        bottom: 120%;
        left: 50%;
        margin-left: -60px;
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;
        
        /* Position the tooltip text - see examples below! */
        position: absolute;
        z-index: 1;
    }
    .icon__main:hover .tool__tip {
        visibility: visible;
      }
```
##Footer link 
<br>
Xoá twitter, insta, thêm target = "_blank" để mở tab mới
