@extends('service.mlops.testingTool.index')
<style>
    .zoom-image-parent {
        max-width: 200px;
        height: auto;
        position: relative;
        margin: 0;
    }

    .zoom-image {
        width: 100%;
        height: auto;
        border: 1px solid white;
    }

    .zoom-image-parent:hover, .zoom-image-parent:active {
        cursor: zoom-in;
        display: block;
    }

    .zoom-image-parent:hover .zoom-image-overlay, .zoom-image-parent:active .zoom-image-overlay {
        opacity: 1;
    }

    .zoom-image-overlay {
        width: 200px;
        height: 200px;
        box-shadow: 0 5px 10px -2px rgba(0, 0, 0, 0.3);
        pointer-events: none;
        position: absolute;
        opacity: 0;
        border: 4px solid whitesmoke;
        z-index: 99;
        border-radius: 100%;
        display: block;
        transition: opacity .2s;
        background-repeat: no-repeat;
    }

</style>
@section('testing-tool-content')
    <div class="block block-rounded">
        <div class="row img-result-content">
            <div class="col-md-6" style="margin-left: 84px">
                <div style="width: 600px">
                    <div class="row text-center">
                        <h5>Ref. No.:{{$resultData['rawDataInfo']['ref_no']}}</h5>
                    </div>
                    <div class="row">
                        <span class="col-auto">
                            <label class="form-check form-check-single form-switch">
                                <input id="toggleZoom" class="form-check-input" type="checkbox"
                                       checked> <h6>Toggle Zoom</h6>
                            </label>
                        </span>
                    </div>
                    <div class="row">
                        @foreach($resultData['rawDataList'] as $value)

                            <div class="col-md-2 p-0 zoom-image-parent">
                                <img alt="" class="zoom-image" id="box{{$value['id']}}"
                                     src="{{  env("FILE_SERVER_DOMAIN") . $value['path'] . env("FILE_SERVER_SECRET_KEY")}}"
                                     onclick="enlargeImage({{$value['id']}},
                                     '{{$value["manual_result"] == '' ?  $value["ai_result"] : $value["manual_result"]}}',
                                     '{{$value['manual_code'] ==''?$value['ai_code']:$value['manual_code']}}',
                                     '{{$value['remarks']}}')"/>
                                <div class="zoom-image-overlay"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row text-center" style="margin-top: 20px">
                        @if($resultData['previousKey']!==-1)
                            <div class="col-md-6">
                                <a href="{{ route('manual_judgment.labelling',['serviceVersionId'=>$serviceVersionId,"jobId"=>$resultData['jobId'],"nextKey"=>$resultData['previousKey']]) }}"
                                   class="btn btn-primary">Previous</a>
                            </div>
                        @endif
                        @if($resultData['nextKey']!==-1)
                            <div class="col-md-6">
                                <a href="{{ route('manual_judgment.labelling',['serviceVersionId'=>$serviceVersionId,"jobId"=>$resultData['jobId'],"nextKey"=>$resultData['nextKey']]) }}"
                                   class="btn btn-primary">Next</a>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="img-result-info" style="margin-left: 120px;display: none">
                <h4>info</h4>
                <form id="img-result-info-form">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Result</span>
                        <select class="form-control" name="manual_result" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" id="mlops_insp_ai_result">
                            <option value="G">G</option>
                            <option value="NG">NG</option>
                        </select>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Defect Classification</span>
                        <select class="form-control" name="manual_code" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" id="mlops_insp_ai_code">
                            <option value=""></option>
                            <option value="Bubbles">Bubbles</option>
                            <option value="Mushroom Defect">Mushroom Defect</option>
                            <option value="Oxidation">Oxidation</option>
                            <option value="Resist Residue">Resist Residue</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="" id="mlops_insp_ai_id">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Remarks</span>
                        <input type="text" name="remarks" class="form-control" aria-label="Sizing example input"
                               aria-describedby="inputGroup-sizing-sm" id="mlops_insp_ai_remarks">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="subDataReport()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        function enlargeImage(id, result, code, remarks) {
            document.getElementById('mlops_insp_ai_id').value = id
            document.getElementById("mlops_insp_ai_result").value = result;
            document.getElementById("mlops_insp_ai_code").value = code;
            document.getElementById('mlops_insp_ai_remarks').value = remarks
            $("#img-result-info").css("display", "block");

            var boxes = document.getElementsByClassName('zoom-image');
            for (var i = 0; i < boxes.length; i++) {
                boxes[i].style.borderColor = 'white';
            }
            $("#box" + id + "").css("border", "1px solid #00FFFF")
        }

        function subDataReport() {
            let token = $("meta[name='csrf-token']").attr("content");
            var form = document.getElementById("img-result-info-form");
            var formData = new FormData(form);
            formData.append("_token", token)
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/data_report/update", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("success")
                    location.reload();
                }
            };
            xhr.send(formData);
        }

        jQuery(document).ready(function () {
            $('.zoom-image-parent').each(function () {
                //document.addEventListener('DOMContentLoaded', function () {
                var img1 = $(this).find('.zoom-image');
                var src1 = img1.attr('src');
                var img2 = $(this).find('.zoom-image-overlay');
                img2[0].style.backgroundImage = "url('" + src1 + "')";


                $(this).on('mousemove', function (e) {
                    let original = img1[0],
                        magnified = img2[0],
                        style = magnified.style,
                        x = e.pageX - this.offsetLeft,
                        y = e.pageY - this.offsetTop,
                        imgWidth = original.offsetWidth,
                        imgHeight = original.offsetHeight,
                        xperc = ((x / imgWidth) * 100),
                        yperc = ((y / imgHeight) * 100);


                    //lets user scroll past right edge of image
                    if (x > (.01 * imgWidth)) {
                        xperc += (.15 * xperc);
                    }
                    ;

                    //lets user scroll past bottom edge of image
                    if (y >= (.01 * imgHeight)) {
                        yperc += (.15 * yperc);
                    }
                    ;

                    style.backgroundPositionX = (xperc - 9) + '%';
                    style.backgroundPositionY = (yperc - 9) + '%';

                    style.left = (x - 180) + 'px';
                    style.top = (y - 180) + 'px';
                });


            });
        });

        const toggleZoomInput = document.getElementById('toggleZoom');
        toggleZoomInput.addEventListener('click', function () {
            var zoomImageOverlay = document.getElementsByClassName("zoom-image-overlay")
            for (var i = 0; i < zoomImageOverlay.length; i++) {
                if (toggleZoomInput.checked) {
                    zoomImageOverlay[i].style.display = 'block';
                } else {
                    zoomImageOverlay[i].style.display = 'none';
                }
            }
        });
    </script>
@endsection
