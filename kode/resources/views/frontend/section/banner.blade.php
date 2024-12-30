<div class="banner">
    <div class="banner-wave">
        <svg width="100%" height="100%" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" overflow="auto" shape-rendering="auto" fill="#ffffff">
            <defs>
             <path id="wavepath" d="M 0 2000 0 500 Q 39.5 453 79 500 t 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0  v1000 z" />
             <path id="motionpath" d="M -158 0 0 0" />
            </defs>
            <g >
             <use xlink:href="#wavepath" y="322">
             <animateMotion
              dur="5s"
              repeatCount="indefinite">
              <mpath xlink:href="#motionpath" />
             </animateMotion>
             </use>
            </g>
          </svg>
    </div>
    <div class="banner-wave-top">
        <svg width="100%" height="100%" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" overflow="auto" shape-rendering="auto" fill="#ffffff">
            <defs>
             <path id="wavepath2" d="M 0 2000 0 500 Q 39.5 453 79 500 t 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0 79 0  v1000 z" />
             <path id="motionpath2" d="M -158 0 0 0" />
            </defs>
            <g >
             <use xlink:href="#wavepath" y="322">
             <animateMotion
              dur="5s"
              repeatCount="indefinite">
              <mpath xlink:href="#motionpath" />
             </animateMotion>
             </use>
            </g>
          </svg>
    </div>
    <div class="banner-triangle"></div>
    <div class="banner-vertical-text">
        <h2>{{translate('Support')}}</h2>
    </div>
    <div class="banner-wrapper">
        <div class="container">
            <div class="row gy-5 justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="banner-content">
                        <h1>
                            {{@frontend_section_data($banner->value,'title')}}
                        </h1>
                        <p>  {{@frontend_section_data($banner->value,'description')}}
                        </p>
                        <div class="banner-search position-relative">
                            <form class="banner-searchform" action="{{route('article.search')}}" method="post">
                                @csrf
                                <span><i class="bi bi-search"></i></span>
                                <input class="article-search" type="search" id="home-search" name="search" placeholder="{{translate("Search Your Question ....")}}">
                                <button type="submit" class="btn--lg btn-icon-hover search-btn d-flex align-items-center justify-content-center gap-2">
                                    <span>{{translate("Search")}}</span>
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </form>


                            <div class="live-search d-none">

                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-8 col-sm-10 col-10 offset-lg-1">
                    <div class="banner-img position-relative">
                        <img src="{{getImageUrl(getFilePaths()['frontend']['path']."/". @frontend_section_data($banner->value,'banner_image')) }}" alt="{{@frontend_section_data($banner->value,'banner_image')}}">


                        <div class="banner-shape shape-1 slideTopBottom">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                ="http://svgjs.com/svgjs" x="0" y="0" viewBox="0 0 512 512"
                                style="enable-background:new 0 0 512 512" xml:space="preserve" >
                                <g>
                                    <path
                                        d="m421.7 146.3-120-120c-1.5-1.5-3.5-2.3-5.7-2.3H96c-4.4 0-8 3.6-8 8v448c0 4.4 3.6 8 8 8h320c4.4 0 8-3.6 8-8V152c0-2.1-.8-4.2-2.3-5.7zM304 51.3l92.7 92.6H304zM408 472H104V40h184v112c0 4.4 3.6 8 8 8h112z"
                                        data-original="#000000" ></path>
                                    <path
                                        d="M354 220c0 4.4-3.6 8-8 8H166c-4.4 0-8-3.6-8-8s3.6-8 8-8h180c4.4 0 8 3.6 8 8zM354 268c0 4.4-3.6 8-8 8H166c-4.4 0-8-3.6-8-8s3.6-8 8-8h180c4.4 0 8 3.6 8 8zM354 316c0 4.4-3.6 8-8 8H166c-4.4 0-8-3.6-8-8s3.6-8 8-8h180c4.4 0 8 3.6 8 8zM354 364c0 4.4-3.6 8-8 8H166c-4.4 0-8-3.6-8-8s3.6-8 8-8h180c4.4 0 8 3.6 8 8zM354 412c0 4.4-3.6 8-8 8H166c-4.4 0-8-3.6-8-8s3.6-8 8-8h180c4.4 0 8 3.6 8 8z"
                                        data-original="#000000" ></path>
                                </g>
                            </svg>
                        </div>
                        <div class="banner-shape shape-2 slideLeftRight">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                ="http://svgjs.com/svgjs" x="0" y="0" viewBox="0 0 512.001 512"
                                style="enable-background:new 0 0 512 512" xml:space="preserve" >
                                <g>
                                    <path
                                        d="M412 136c0 5.52 4.48 10 10 10s10-4.48 10-10-4.48-10-10-10-10 4.48-10 10zM452 256c0 12.809-1.285 25.594-3.816 38-1.106 5.41 2.386 10.691 7.796 11.797.676.14 1.348.207 2.012.207 4.653 0 8.82-3.27 9.79-8.004 2.8-13.723 4.218-27.852 4.218-42 0-31.488-6.828-61.79-20.3-90.063-2.376-4.984-8.34-7.101-13.329-4.726-4.988 2.375-7.101 8.344-4.726 13.332C445.825 200.105 452 227.512 452 256zM306 346h-10V216c0-5.523-4.477-10-10-10h-80c-5.523 0-10 4.477-10 10v40c0 5.523 4.477 10 10 10h10v80h-10c-5.523 0-10 4.477-10 10v40c0 5.523 4.477 10 10 10h100c5.523 0 10-4.477 10-10v-40c0-5.523-4.477-10-10-10zm-10 40h-80v-20h10c5.523 0 10-4.477 10-10V256c0-5.523-4.477-10-10-10h-10v-20h60v130c0 5.523 4.48 10 10 10h10zM256 186c22.055 0 40-17.945 40-40s-17.945-40-40-40-40 17.945-40 40 17.945 40 40 40zm0-60c11.027 0 20 8.973 20 20s-8.973 20-20 20-20-8.973-20-20 8.973-20 20-20zm0 0"
                                        data-original="#000000"></path>
                                    <path
                                        d="M256 0C118.023 0 0 117.8 0 256c0 47.207 13.527 97.41 36.336 135.383L.512 498.84a9.999 9.999 0 0 0 12.652 12.644l107.457-35.82C158.59 498.477 208.793 512 256 512c138.012 0 256-117.816 256-256C512 117.988 394.187 0 256 0zm0 492c-45.285 0-93.418-13.363-128.758-35.746a9.996 9.996 0 0 0-8.515-1.04l-92.915 30.974 30.973-92.915a9.987 9.987 0 0 0-1.039-8.515C33.363 349.422 20 301.285 20 256 20 128.074 128.074 20 256 20s236 108.074 236 236-108.074 236-236 236zm0 0"
                                        data-original="#000000"></path>
                                </g>
                            </svg>
                        </div>

                        <div class="banner-shape shape-3 slideTopBottom">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                ="http://svgjs.com/svgjs" x="0" y="0" viewBox="0 0 512 512.001"
                                style="enable-background:new 0 0 512 512" xml:space="preserve" >
                                <g>
                                    <path
                                        d="M448.246 76.563c-74.504 0-172.531-25.141-207.473-71.72-4.648-5.66-13.003-6.476-18.664-1.827a13.042 13.042 0 0 0-1.828 1.828C185.336 51.418 87.31 76.563 12.81 76.563 5.734 76.563 0 82.296 0 89.37V255.86C0 396.687 122.293 481.586 227.012 511.5c2.297.668 4.734.668 7.031 0 104.719-29.914 227.012-114.813 227.012-255.64V89.37c0-7.074-5.735-12.808-12.809-12.808zm-12.808 179.296c0 125.02-109.56 201.66-204.91 230.004C135.175 457.52 25.612 380.88 25.612 255.86V101.953C99.641 99.45 187.18 75.586 230.527 31.988 273.88 75.586 361.414 99.45 435.441 101.95v153.91zm0 0"
                                        data-original="#000000" ></path>
                                    <path
                                        d="M179.3 204.633v25.613h-12.808c-7.074 0-12.808 5.734-12.808 12.809v102.453c0 7.074 5.734 12.808 12.808 12.808h128.07c7.075 0 12.81-5.734 12.81-12.808V243.055c0-7.075-5.735-12.809-12.81-12.809h-12.808v-25.613c0-28.293-22.934-51.227-51.227-51.227-28.293 0-51.226 22.934-51.226 51.227zm102.454 128.07H179.3V255.86h102.453zm-25.613-128.07v25.613h-51.227v-25.613c0-14.145 11.465-25.613 25.613-25.613 14.145 0 25.614 11.468 25.614 25.613zm0 0"
                                        data-original="#000000" ></path>
                                </g>
                            </svg>
                        </div>

                        <div class="banner-shape shape-4 slideLeftRight">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                ="http://svgjs.com/svgjs" x="0" y="0" viewBox="0 0 422.139 422.139"
                                style="enable-background:new 0 0 512 512" xml:space="preserve" >
                                <g>
                                    <path
                                        d="M363.631 174.498h-1.045v-25.6C362.586 66.664 295.923 0 213.688 0S64.79 66.664 64.79 148.898v25.6h-6.269c-22.988 0-40.751 20.375-40.751 43.886v65.306c-.579 22.787 17.425 41.729 40.212 42.308.18.005.359.008.539.01h38.661c5.476-.257 9.707-4.906 9.449-10.382a9.695 9.695 0 0 0-.045-.59v-128c0-6.269-3.657-12.539-9.404-12.539H85.688v-25.6c0-70.692 57.308-128 128-128s128 57.308 128 128v25.6h-11.494c-5.747 0-9.404 6.269-9.404 12.539v128c-.583 5.451 3.363 10.343 8.814 10.926.196.021.393.036.59.045h12.016l-1.045 1.567a82.545 82.545 0 0 1-66.351 32.914c-5.708-27.989-33.026-46.052-61.015-40.343-23.935 4.881-41.192 25.843-41.385 50.27.286 28.65 23.594 51.724 52.245 51.722a53.812 53.812 0 0 0 37.616-16.196 45.978 45.978 0 0 0 12.539-25.078 103.443 103.443 0 0 0 83.069-41.273l9.927-14.629c22.465-1.567 36.571-15.673 36.571-36.049v-65.306c.001-22.463-16.717-49.108-40.75-49.108zM85.688 305.11H58.521c-11.25-.274-20.148-9.615-19.874-20.865.005-.185.012-.37.021-.556v-65.306c0-12.016 8.359-22.988 19.853-22.988h27.167V305.11zm161.437 86.204a30.826 30.826 0 0 1-22.465 9.927c-16.998-.27-30.792-13.834-31.347-30.825-.007-17.024 13.788-30.83 30.812-30.837 17.024-.007 30.83 13.788 30.837 30.812v.025a27.692 27.692 0 0 1-7.837 20.898zm136.359-102.4c0 14.106-13.584 16.196-19.853 16.196h-21.943V195.396h21.943c11.494 0 19.853 16.196 19.853 28.212v65.306z"
                                        data-original="#000000"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

