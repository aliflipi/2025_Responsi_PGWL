<div id="container">
    <!-- Sidebar -->
    <div class="sidebar_left ;">
        <div class="sidebar-header;">
            <h2>MENU</h2>
        </div>
        <ul class="sidebar-menu">
            <li onclick="showContent('layer')">Layer</li>
            <li onclick="showContent('legenda')">Legenda</li>
            <li onclick="showContent('basemap')">Basemap</li>
        </ul>
    </div>

    <!-- Placeholder untuk konten legenda -->
    <div id="sidebarLegend" style="display: none; padding: 10px;"></div>

    <!-- SIDEBAR LAYER DATA -->
    <div id="layerContent" style="display: none; padding: 20px;">
        <h4 class="overlay-title">Overlay Maps</h4>
        <ul class="overlay-list">
            <li>
                <label>
                    <input type="checkbox" id="kkpr_2022" onclick="toggleLayer(kkpr_2022, this.checked)" checked>
                    <span>Data Tahun 2022</span>
                </label>
            </li>
            <li>
                <label>
                    <input type="checkbox" id="kkpr_2023" onclick="toggleLayer(kkpr_2023, this.checked)" checked>
                    <span>Data Tahun 2023</span>
                </label>
            </li>
        </ul>
    </div>


    <div id="basemapContent" style="display: none; padding: 20px;">
        <h4 class="basemap-title">Base Maps</h4>
        <ul class="basemap-list">
            <li>
                <label>
                    <input type="radio" name="basemap" onclick="setBasemap('OpenStreetMap')">
                    <span>OpenStreetMap</span>
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="basemap" onclick="setBasemap('Esri World Imagery')">
                    <span>Esri World Imagery</span>
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="basemap" onclick="setBasemap('Topographic')">
                    <span>Topographic</span>
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="basemap" onclick="setBasemap('RupaBumi Indonesia')">
                    <span>RupaBumi Indonesia</span>
                </label>
            </li>
        </ul>
    </div>
</div>
