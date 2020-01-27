<section class="theme-popup video-upload-bg">
    <div class="msg-container">
        <div class="msg-hed">
            <h3>Upload Video</h3>
            <span id="msg-close">&times;</span>
        </div>
        <div class="msg-body">
            <form id="video-upload-form">
                <div class="form-widget perso my-4 gallery-brouser-area">
                    <div class="form-group">
                        <label for="video_type">Show Type:</label>
                        <!-- <select name="video_type" id="video_type" class="custom-select">
                            <option value="free_view">Free View</option>
                            <option value="private_open">Private Open</option>
                            <option value="private_closed">Private Closed</option>
                            <option value="group">Group</option>
                            <option value="spy">Spy</option>
                        </select> -->
                        <select name="type" id="type" class="form-control username formsm display_gal_img1">
                            <option value="1">Free Content</option>
                            <option value="2">Premium Content</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="video_file">Select Video</label>
                        <button type="button" id="btn-video-select" class="brouse-input" >Choose...</button>
                        <video src="" id="videoElem" height="200" style="display:none" controls>
                        <input type="file" name="video_file" id="video_file" onchange="onVideoChange(this)" style="display:none" accept="video/mp4">
                    </div>
                    <div class="form-group form-action mt-3">
                        <input type="button" value="Upload Video" id="video_submit_btn">
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>