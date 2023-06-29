# Mới sửa

## Tool tip

```bash
//home.blade.php line 53, aboutUs.blade.php line 33

<div class="tech__box">
    <div class="icon__wrapper">
        <div class="icon__main">
            <i class="fa-brands fa-php"></i>
            <span class="tool__tip">{{ __('php_tooltip') }}</span>
        </div>
    </div>
    <div class="icon__wrapper">
        <div class="icon__main">
            <i class="fa-brands fa-node-js"></i>
            <span class="tool__tip">{{ __('js_tooltip') }}</span>
        </div>
    </div>
    <div class="icon__wrapper">
        <div class="icon__main">    
            <i class="fa-brands fa-react"></i>
            <span class="tool__tip">{{ __('react_tooltip') }}</span>
        </div>
    </div>
    <div class="icon__wrapper">
        <div class="icon__main">
            <i class="fa-brands fa-css3-alt"></i>
            <span class="tool__tip">{{ __('css_tooltip') }}</span>
        </div>
    </div>
</div>

//home.scss line 19, about.scss line 69

.icon__main {
        position: relative;
        
        &:hover {
            .tool__tip {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        .tool__tip {
            color: #f0f0f0;
            position: absolute;
            left: 50%;
            bottom: 100%;
            opacity: 0;
            margin-bottom: 1em;
            word-break: break-word;
            padding: 1em;
            background-color: #000;
            font-size: 14px;
            max-width: 400px;
            width: max-content;
            line-height: 1.6;
            text-align: left;
            white-space: normal;
            transform: translate(-50%, 1em);
            transition: all .35s ease-in-out;
            &::before {
                content: '';
                position: absolute;
                top: 100%;
                left: 50%;
                width: 0;
                height: 0;
                border: .5em solid transparent;
                border-top-color: #000;
                transform: translate(-50%, 0);
            }
        }
    }
```
## language tại ncsoft
home.blade.php / line 472

```bash
<div class="container programming-language mb-5">
    <div class="row">
        <div class=" col-md-12 col-lg-6">
            <div class="content__common">
                <div class="heading__subtitle">
                    {{ __('heading__subtitle') }}     //// thêm vào content language
                </div>
                <div class="content__heading programming-language-heading">
                    <h2>{{ __('programming_language_heading_home') }}</h2>
                    <p class="content__title my-4">
                        {{ __('programming_language_title_home') }}
                    </p>
                </div>
                <a href = "#" class="btn btn__custom-h">
                    <i class="fa-solid fa-gears"></i>
                    {{ __('button_programming_home') }}
                </a>
            </div>
        </div>
```
