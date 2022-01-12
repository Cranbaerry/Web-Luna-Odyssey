@extends('layouts.main')
@section('content')
    <div class="row tile px-0 py-3" style="box-shadow: none; background:none;">
        <div class="col-12">
            <div class="subtitle">Download and Installation Guide</div>
            <ul class="list-group pt-2 pb-2">
                <li class="list-group-item">1. Download Odyssey Luna from any of the source listed below.</li>
                <li class="list-group-item">2. Install the program according to the instruction.</li>
                <li class="list-group-item">3. After program has been installed, please exclude the “Odyssey Luna” folder from your Windows Defender Scan by following <a href="https://www.windowscentral.com/how-exclude-files-and-folders-windows-defender-antivirus-scans" target="_blank">this link</a>.</li>
                <li class="list-group-item">4. Launch the game as usual.</li>
                <li class="list-group-item">5. If any abnormalities / error occured, please contact us through <a href="{{ Helper::getSetting('social_discord') }}" target="_blank">Discord</a>.</li>
            </ul>
        </div>
        <div class="col-12">
            <div class="main_left_section">
                <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                    <div class="card shadow-sm mb-3 card-bg-transparent" align="center">
                        <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                            <div class="edgtf-tt-item-outer edgtf-with-link">
                                <div class="edgtf-tt-item-holder">
                                    <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                    </div>
                                    <div class="edgtf-tt-message edgtf-tt-section">
                                        DOWNLOAD LINKS
                                    </div>
                                    <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                    </div>
                                    <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Latest Version</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        {{ Helper::getSetting('patch_version') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Patch Date</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        {{ Helper::getSetting('patch_date') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div>
                                        <strong>Google Drive</strong>
                                        <a href="{{ Helper::getSetting('patch_dl_gdrive') }}" style="font-weight: 100;" target="_blank">
                                            <img class="img-fluid p-1" src="{{ asset('storage/img/download-icon/gdrive.png')}}" style="height: 50px"></img>
                                        </a>
                                    </div>
                                    <div>
                                        <strong>Mediafire</strong> <a href="{{ Helper::getSetting('patch_dl_mfire') }}" style="font-weight: 100;" target="_blank">
                                            <img class="img-fluid p-1" src="{{ asset('storage/img/download-icon/mediafire.png')}}" style="height: 50px"></img>
                                        </a>
                                    </div>
                                    <div>
                                        <strong>Mega</strong> <a href="{{ Helper::getSetting('patch_dl_mega') }}" style="font-weight: 100;" target="_blank">
                                            <img class="img-fluid p-1" src="{{ asset('storage/img/download-icon/mega.png')}}" style="height: 50px"></img>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="main_left_section">
                <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                    <div class="card shadow-sm mb-3 card-bg-transparent" align="center">
                        <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                            <div class="edgtf-tt-item-outer edgtf-with-link">
                                <div class="edgtf-tt-item-holder">
                                    <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                    </div>
                                    <div class="edgtf-tt-message edgtf-tt-section">
                                        MIN. SYSTEM REQUIREMENTS
                                    </div>
                                    <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                    </div>
                                    <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>CPU</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents; ">
                                        <a href="#" class="font-weight-light" style="color:#6393ab">Pentium 4, Dual Core or higher</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>GPU</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        <a href="#" class="font-weight-light" style="color:#6393ab">GeForce 8600 or higher</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div>
                                        <strong>OS</strong> <a href="#" class="font-weight-light" style="color:#6393ab">Windows XP SP3</a>
                                    </div>
                                    <div>
                                        <strong>RAM</strong> <a href="#" class="font-weight-light" style="color:#6393ab">4 GB or higher</a>
                                    </div>
                                    <div>
                                        <strong>Space</strong> <a href="#" class="font-weight-light" style="color:#6393ab">3GB or higher</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="main_left_section">
                <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                    <div class="card shadow-sm mb-3 card-bg-transparent" align="center">
                        <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                            <div class="edgtf-tt-item-outer edgtf-with-link">
                                <div class="edgtf-tt-item-holder">
                                    <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                    </div>
                                    <div class="edgtf-tt-message edgtf-tt-section">
                                        RECOMMENDED SETTINGS
                                    </div>
                                    <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                    </div>
                                    <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>CPU</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        <a href="#" class="font-weight-light" style="color:#6393ab">Pentium Core i7 530 or higher</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>GPU</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        <a href="#" class="font-weight-light" style="color:#6393ab">Nvidia GTX 250</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div>
                                        <strong>OS</strong> <a href="#" class="font-weight-light" style="color:#6393ab">Windows 7 (32 bit)</a>
                                    </div>
                                    <div>
                                        <strong>RAM</strong> <a href="#" class="font-weight-light" style="color:#6393ab">8 GB or higher</a>
                                    </div>
                                    <div>
                                        <strong>Space</strong> <a href="#" class="font-weight-light" style="color:#6393ab">5GB or higher</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
