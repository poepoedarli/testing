<h5 class="text-primary-dark fw-semibold text-center">{{$title}}</h5>
<ul class="timeline timeline-centered timeline-alt">
    <li class="timeline-event">
        <div class="timeline-event-icon bg-primary-light">
            <i class="fa fa-cloud-arrow-up"></i>
        </div>
        <div class="timeline-event-block block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Upload Images</h3>
            </div>
            <div class="block-content">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p>
                            <a class="fw-semibold pe-none" href="">Cloud Storage: </a>
                            Please upload your dataset images to Cloud Storage. Currently, our system only works Azure Storage.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="timeline-event">
        <div class="timeline-event-icon bg-primary-light">
            <i class="fa fa-database"></i>
        </div>
        <div class="timeline-event-block block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Create Dataset</h3>
            </div>
            <div class="block-content">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p>
                            <a class="fw-semibold pe-none" href="">Create Dataset: </a>
                            Please create a new dataset by using your image folder path at <a class="fw-semibold" href="{{request()->getSchemeAndHttpHost()}}/datasets">{{request()->getSchemeAndHttpHost()}}/datasets</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="timeline-event">
        <div class="timeline-event-icon bg-primary-light">
            <i class="fab fa-servicestack"></i>
        </div>
        <div class="timeline-event-block block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Done</h3>
            </div>
            
        </div>
    </li>
</ul>