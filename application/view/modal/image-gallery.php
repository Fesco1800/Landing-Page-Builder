<!-- Bottom Section Image Gallery Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="imageGalleryModalContent">
            <div class="modal-header">
                <h5 class="modal-title" id="imageGalleryModalLabel">Image Gallery</h5>
                <div class="imageCategorySelect">
                    <select id="imageCategory">
                        <option value="select">Select</option>
                        <option value="industry">Industry</option>
                        <option value="color-gradient">Color and Gradient</option>
                        <option value="abstract">Abstract</option>
                    </select>
                </div>
            </div>
            <hr class="bg-white">
            <div class="modal-body">
                <div class="loader image-gallery-loader d-none"></div>
                <div id="gradientColorInput">
                    <div class="graphick-container">
                        <div class="grapick-cont">
                            <div id="grapick"></div>
                            <div class="grp-inputs">
                                <select class="grp-form-control form-control me-1" id="switch-type">
                                    <option value="">- Select Type -</option>
                                    <option value="radial">Radial</option>
                                    <option value="linear">Linear</option>
                                    <option value="repeating-radial">Repeating Radial</option>
                                    <option value="repeating-linear">Repeating Linear</option>
                                </select>

                                <select class="grp-form-control form-control" id="switch-angle">
                                    <option value="">- Select Direction -</option>
                                    <option value="top">Top</option>
                                    <option value="right">Right</option>
                                    <option value="center">Center</option>
                                    <option value="bottom">Bottom</option>
                                    <option value="left">Left</option>
                                </select>
                            </div>
                            <div class="grp-copy-grid">
                                <textarea class="txt-value" readonly></textarea>
                                <button class="grp-select-btn" id="grp-select-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- <div id="imageGallery" class="row gallery"></div> -->
                    <!-- Bottom Section -->
                    <div class="container bottom-predefined-colors-gradients">
                        <!-- Gradients Section -->
                        <div class="section">
                            <h2>Gradients</h2>
                            <div class="box-container">
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(45deg, #f3ec78, #af4261)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #ff7e5f, #feb47b)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #6a11cb, #2575fc)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #ff512f, #f09819)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(45deg, #85FFBD 0%, #FFFB7D 100%)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #4b6cb7, #182848)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #414d0b, #727a17)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #8360c3, #2ebf91)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #59c173, #a17fe0, #5d26c1)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #ad5389, #3c1053)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #e1eec3, #f05053)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #000428, #004e92)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #0f2027, #203a43, #2c5364)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #1f4037, #99f2c8)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #ffefba, #ffffff)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #3c3b3f, #605c3c)"></div>
                                <div class="gradient-box bottom-gradient" style="background: linear-gradient(to right, #41295a, #2f0743)"></div>
                            </div>
                        </div>

                        <!-- Solid Colors Section -->
                        <div class="section">
                            <h2>Solid Colors</h2>
                            <div class="box-container">
                                <div class="solid-box bottom-solid" style="background: #3498db"></div>
                                <div class="solid-box bottom-solid" style="background: #2ecc71"></div>
                                <div class="solid-box bottom-solid" style="background: #e74c3c"></div>
                                <div class="solid-box bottom-solid" style="background: #f39c12"></div>
                                <div class="solid-box bottom-solid" style="background: #111827"></div>
                                <div class="solid-box bottom-solid" style="background: #F3F4F6"></div>
                                <div class="solid-box bottom-solid" style="background: #14B8A6"></div>
                                <div class="solid-box bottom-solid" style="background: #F87171"></div>
                                <div class="solid-box bottom-solid" style="background: #EC4899"></div>
                                <div class="solid-box bottom-solid" style="background: #FACC15"></div>
                                <div class="solid-box bottom-solid" style="background: #C084FC"></div>
                                <div class="solid-box bottom-solid" style="background: #A3A3A3"></div>
                                <div class="solid-box bottom-solid" style="background: #F43F5E"></div>
                                <div class="solid-box bottom-solid" style="background: #FFB3B3"></div>
                                <div class="solid-box bottom-solid" style="background: #FF6D00"></div>
                                <div class="solid-box bottom-solid" style="background: #6B7280"></div>
                                <div class="solid-box bottom-solid" style="background: #F5A623"></div>
                                <div class="solid-box bottom-solid" style="background: #9D174D"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="abstractInput">
                    <div class="gg-container">
                        <div class="gg-box gg-box-abstract">
                            <!-- grid-gallery here -->
                        </div>
                    </div>
                </div>
                <div class="industryInput">
                    <div class="gg-container gg-industry-container"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Mid Section Image Gallery Modal -->
<div class="modal fade" id="midImageModal" tabindex="-1" aria-labelledby="imageGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="midImageGalleryModalContent">
            <div class="modal-header">
                <h5 class="modal-title" id="imageGalleryModalLabel">Image Gallery</h5>
                <div class="imageCategorySelect">
                    <select id="midImageCategory">
                        <option value="select">Select</option>
                        <option value="industry">Industry</option>
                        <option value="color-gradient">Color and Gradient</option>
                        <option value="abstract">Abstract</option>
                    </select>
                </div>
            </div>
            <hr class="bg-white">
            <div class="modal-body">
                <div class="loader image-gallery-loader d-none"></div>
                <div id="midGradientColorInput">
                    <div class="graphick-container">
                        <div class="grapick-cont">
                            <div class="mid-grapick" id="grapick"></div>
                            <div class="grp-inputs">
                                <select class="grp-form-control form-control me-1" id="mid-switch-type">
                                    <option value="">- Select Type -</option>
                                    <option value="radial">Radial</option>
                                    <option value="linear">Linear</option>
                                    <option value="repeating-radial">Repeating Radial</option>
                                    <option value="repeating-linear">Repeating Linear</option>
                                </select>

                                <select class="grp-form-control form-control" id="mid-switch-angle">
                                    <option value="">- Select Direction -</option>
                                    <option value="top">Top</option>
                                    <option value="right">Right</option>
                                    <option value="center">Center</option>
                                    <option value="bottom">Bottom</option>
                                    <option value="left">Left</option>
                                </select>
                            </div>
                            <div class="grp-copy-grid">
                                <textarea class="txt-value" id="mid-txt-value" readonly></textarea>
                                <button class="grp-select-btn" id="mid-grp-select-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- <div id="imageGallery" class="row gallery"></div> -->
                    <div class="container mid-predefined-colors-gradients">
                        <!-- Gradients Section -->
                        <div class="section">
                            <h2>Gradients</h2>
                            <div class="box-container">
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(45deg, #f3ec78, #af4261)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #ff7e5f, #feb47b)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #6a11cb, #2575fc)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #ff512f, #f09819)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(45deg, #85FFBD 0%, #FFFB7D 100%)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #4b6cb7, #182848)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #414d0b, #727a17)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #8360c3, #2ebf91)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #59c173, #a17fe0, #5d26c1)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #ad5389, #3c1053)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #e1eec3, #f05053)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #000428, #004e92)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #0f2027, #203a43, #2c5364)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #1f4037, #99f2c8)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #ffefba, #ffffff)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #3c3b3f, #605c3c)"></div>
                                <div class="gradient-box mid-gradient" style="background: linear-gradient(to right, #41295a, #2f0743)"></div>
                            </div>
                        </div>

                        <!-- Solid Colors Section -->
                        <div class="section">
                            <h2>Solid Colors</h2>
                            <div class="box-container">
                                <div class="solid-box mid-solid" style="background: #3498db"></div>
                                <div class="solid-box mid-solid" style="background: #2ecc71"></div>
                                <div class="solid-box mid-solid" style="background: #e74c3c"></div>
                                <div class="solid-box mid-solid" style="background: #f39c12"></div>
                                <div class="solid-box mid-solid" style="background: #111827"></div>
                                <div class="solid-box mid-solid" style="background: #F3F4F6"></div>
                                <div class="solid-box mid-solid" style="background: #14B8A6"></div>
                                <div class="solid-box mid-solid" style="background: #F87171"></div>
                                <div class="solid-box mid-solid" style="background: #EC4899"></div>
                                <div class="solid-box mid-solid" style="background: #FACC15"></div>
                                <div class="solid-box mid-solid" style="background: #C084FC"></div>
                                <div class="solid-box mid-solid" style="background: #A3A3A3"></div>
                                <div class="solid-box mid-solid" style="background: #F43F5E"></div>
                                <div class="solid-box mid-solid" style="background: #FFB3B3"></div>
                                <div class="solid-box mid-solid" style="background: #FF6D00"></div>
                                <div class="solid-box mid-solid" style="background: #6B7280"></div>
                                <div class="solid-box mid-solid" style="background: #F5A623"></div>
                                <div class="solid-box mid-solid" style="background: #9D174D"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="midAbstractInput">
                    <div class="gg-container">
                        <div class="gg-box gg-box-abstract">
                            <!-- grid-gallery here -->
                        </div>
                    </div>
                </div>
                <div class="midIndustryInput">
                    <div class="gg-container gg-industry-container"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>