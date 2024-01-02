<!DOCTYPE html>
<html>

<head>
  <title>OfficeJs | Demos </title>
  <meta charset="utf-8">
   <!-- Import Mediaelement CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.6/mediaelementplayer.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement-plugins@latest/dist/quality/quality.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
   <link rel="stylesheet" href="{{ asset('frontend') }}/utilities/audio-video/demo.css">
   <!-- Import Mediaelement JS -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.6/mediaelement-and-player.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/mediaelement-plugins@latest/dist/quality/quality.min.js"></script>
   <script src="{{ asset('frontend') }}/utilities/audio-video/dist/preview/preview.js"></script>

</head>

<body id="top">
   
     <div class="player">
         <video id="player-demo" width="640" height="360" preload="none" style="max-width: 100%" controls="" poster="images/big_buck_bunny.jpg">
             <!-- Add multiple <source>-tags and set text per `data-quality`-attribute -->
             <source type="video/mp4" src="https://download.samplelib.com/mp4/sample-15s.mp4" data-quality="HD">
             <source type="video/mp4" src="https://download.samplelib.com/mp4/sample-10s.mp4" data-quality="SD">
             <source type="video/mp4" src="https://download.samplelib.com/mp4/sample-5s.mp4" data-quality="LD">
             <!-- Just add multiple <track> files, they get integrated automatically -->
             <track src="dist/mediaelement.vtt" srclang="en" label="English" kind="captions" type="text/vtt">
             <track src="dist/mediaelement_german.vtt" srclang="de" label="Deutsch" kind="subtitles" type="text/vtt">
         </video>
     </div>

     <script src="https://cdn.jsdelivr.net/npm/mediaelement@latest/build/mediaelement-and-player.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/mediaelement@latest/build/renderers/dailymotion.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/mediaelement@latest/build/renderers/facebook.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/mediaelement@latest/build/renderers/soundcloud.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/mediaelement@latest/build/renderers/twitch.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/mediaelement@latest/build/renderers/vimeo.min.js"></script>
     <script src="https://buttons.github.io/buttons.js"></script>
     <script src="https://platform.twitter.com/widgets.js"></script>
     <script>
         // You can use either a string for the player ID (i.e., `player`), 
         // or `document.querySelector()` for any selector
        //  const playerQuality = new MediaElementPlayer('player', {
        //      iconSprite: '/images/mejs-controls.svg', // path to svg-spritemap for all icons
        //      features: ['playpause', 'current', 'progress', 'duration', 'volume', 'tracks', 'quality', 'fullscreen'], // add 'quality' feature
        //  });
// ================================================================

         var
                sourcesSelector = document.body.querySelectorAll('select'),
		        sourcesTotal = sourcesSelector.length
            ;

            for (var i = 0; i < sourcesTotal; i++) {
                sourcesSelector[i].addEventListener('change', function (e) {
                    var
                        media = e.target.closest('.media-container').querySelector('.mejs__container').id,
                        player = mejs.players[media]
                    ;

                    player.setSrc(e.target.value.replace('&amp;', '&'));
                    player.setPoster('');
                    player.load();

                });

                // These media types cannot play at all on iOS, so disabling them
                if (mejs.Features.isiOS) {
			        if (sourcesSelector[i].querySelector('option[value^="rtmp"]')) {
                        sourcesSelector[i].querySelector('option[value^="rtmp"]').disabled = true;
                    }
                    if (sourcesSelector[i].querySelector('option[value$="webm"]')) {
                        sourcesSelector[i].querySelector('option[value$="webm"]').disabled = true;
                    }
                    if (sourcesSelector[i].querySelector('option[value$=".mpd"]')) {
                        sourcesSelector[i].querySelector('option[value$=".mpd"]').disabled = true;
                    }
			        if (sourcesSelector[i].querySelector('option[value$=".ogg"]')) {
                        sourcesSelector[i].querySelector('option[value$=".ogg"]').disabled = true;
                    }
			        if (sourcesSelector[i].querySelector('option[value$=".flv"]')) {
                        sourcesSelector[i].querySelector('option[value*=".flv"]').disabled = true;
        		    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                var mediaElements = document.querySelectorAll('video, audio'), total = mediaElements.length;

                for (var i = 0; i < total; i++) {
                    new MediaElementPlayer(mediaElements[i], {
                        // iconSprite: '{{ asset("frontend") }}/utilities/audio-video/mejs-controls.svg',
                        previewMode: true,
                        muteOnPreviewMode: true,
                        fadeOutAudioInterval: 200,
                        fadeOutAudioStart: 10,
                        fadePercent: 0.02,
                        features: ['playpause', 'current', 'progress', 'duration', 'volume', 'fullscreen', 'preview'],
                        success: function () {
                            var target = document.body.querySelectorAll('.player'), targetTotal = target.length;
                            for (var j = 0; j < targetTotal; j++) {
                                target[j].style.visibility = 'visible';
                            }
			            }
		            });
                }
            });
     </script>
</body>

</html>
