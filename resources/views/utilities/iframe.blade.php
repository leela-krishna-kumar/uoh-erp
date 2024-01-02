
<style>
    #previewPath {
        overflow: auto;
        max-width: -webkit-fill-available;
        max-height: -webkit-fill-available;
    }
 
    ::-webkit-scrollbar {
    width: 0!important; /* Hide the scrollbar for webkit browsers (e.g., Chrome) */
    height: 0!important; /* Hide the scrollbar for webkit browsers (e.g., Chrome) */
    }
   
    #previewPath {
    -ms-overflow-style: none; /* Hide the scrollbar for Internet Explorer/Edge */
    }
   
</style>

<div id="previewModal" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">File Preview</h2>
        </div>
        <div class="uk-modal-body">
            <iframe src="" id="previewPath" style="object-fit:contain;width:-webkit-fill-available;height:65vh;"></iframe>
        </div>
    </div>
</div>