<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-home icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Analytic Traffic Occupancy Network Dashboard
                <div class="page-title-subheading">By Telkom Regional 1 & Telkomsel Sumatera
                </div>
            </div>
        </div> 

        <div class="page-title-actions">
            <h6>Filters:</h6>
            <div class="d-inline-block dropdown">
                <select type="select" name="filter_reg" class="custom-select" id="filter_reg">
                    <option>Choose TREG</option>
                    <option value="1">TREG 1</option>
                    <option value="2">TREG 2</option>
                    <option value="3">TREG 3</option>
                    <option value="4">TREG 4</option>
                    <option value="5">TREG 5</option>
                    <option value="6">TREG 6</option>
                    <option value="7">TREG 7</option>
                </select>
            </div>
        </div>   
    </div>
</div>

<div class="row" id="grandtotal">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content">
            <div class="widget-content-outer">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left pr-2 fsize-1">
                        <div class="widget-numbers mt-0 fsize-3 text-success">23</div>
                    </div>
                    <div class="widget-content-right w-100">
                        <div class="progress-bar-xs progress">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100" style="width: 23%;"></div>
                        </div>
                    </div>
                </div>
                <div class="widget-content-left fsize-1">
                    <div class="text-muted opacity-6">UP</div>
                </div>
                <div class="widget-content-right fsize-1">
                    <a class="btn btn-success" href="#" id="up">
                        More Info
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content">
            <div class="widget-content-outer">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left pr-2 fsize-1">
                        <div class="widget-numbers mt-0 fsize-3 text-red">58</div>
                    </div>
                    <div class="widget-content-right w-100">
                        <div class="progress-bar-xs progress">
                            <div class="progress-bar bg-red" role="progressbar" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100" style="width: 58%;"></div>
                        </div>
                    </div>
                </div>
                <div class="widget-content-left fsize-1">
                    <div class="text-muted opacity-6">DOWN</div>
                </div>
                <div class="widget-content-right fsize-1">
                    <a class="btn btn-danger" href="#" id="down">
                        More Info
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content">
            <div class="widget-content-outer">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left pr-2 fsize-1">
                        <div class="widget-numbers mt-0 fsize-3 text-warning">{{$tregUtilTotal->linkStatus["critical"]}}
                        </div>
                    </div>
                    <div class="widget-content-right w-100">
                        <div class="progress-bar-xs progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100" style="width: 28%;"></div>
                        </div>
                    </div>
                </div>
                <div class="widget-content-left fsize-1">
                    <div class="text-muted opacity-6">OCCUPANCY >70</div>
                </div>
                <div class="widget-content-right fsize-1">
                    <a class="btn btn-warning" href="#">
                        More Info
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>