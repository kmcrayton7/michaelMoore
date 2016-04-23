// Uploading files
$j = jQuery.noConflict();
$j(document).ready(function() {
   
    
    $j('#mashog_tw_title').jqEasyCounter({
        'maxChars': 140,
        'maxCharsWarning': 40,
        'msgFontSize': '12px',
        'msgFontColor': '#000',
        'msgFontFamily': 'Arial',
        'msgTextAlign': 'left',
        'msgWarningColor': '#F00',
        'msgAppendMethod': 'insertBefore'              
    });

/* user clicks button on custom field, runs below code that opens new window */
$j('.mashsb_upload_image').click(function() {

/*Thickbox function aimed to show the media window. This function accepts three parameters:
*
* Name of the window: "In our case Upload a Image"
* URL : Executes a WordPress library that handles and validates files.
* ImageGroup : As we are not going to work with groups of images but just with one that why we set it false.
*/
tb_show('Upload a Image', 'media-upload.php?referer=media_page&type=image&TB_iframe=true&post_id=0', false);
return false;
});
// window.send_to_editor(html) is how WP would normally handle the received data. It will deliver image data in HTML format, so you can put them wherever you want.
/* store old send to editor function - 
* must be done to allow multiple instances of send_to_editor. 
* Otherwise image upload does not work in posts any longer
*/
var restore_send_to_editor = window.send_to_editor;

window.send_to_editor = function(html) {
imgurl = $j('img',html).attr('src');
$j('.default_image').val(imgurl);
tb_remove(); // calls the tb_remove() of the Thickbox plugin
}
//restore old send to editor function
window.send_to_editor = restore_send_to_editor;

});

/* jQuery jqEasyCharCounter plugin
 * Examples and documentation at: http://www.jqeasy.com/
 * Version: 1.0 (05/07/2010)
 * No license. Use it however you want. Just keep this notice included.
 * Requires: jQuery v1.3+
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */
(function($) {

$.fn.extend({
    jqEasyCounter: function(givenOptions) {
        return this.each(function() {
            var $this = $(this),
                options = $.extend({
                    maxChars: 100,
					maxCharsWarning: 80,
					msgFontSize: '12px',
					msgFontColor: '#000000',
					msgFontFamily: 'Arial',
					msgTextAlign: 'right',
					msgWarningColor: '#F00',
					msgAppendMethod: 'insertAfter'
                }, givenOptions);
	
			if(options.maxChars <= 0) return;
			
			// create counter element
			var jqEasyCounterMsg = $("<div class=\"jqEasyCounterMsg\">&nbsp;</div>");
			var jqEasyCounterMsgStyle = {
				'font-size' : options.msgFontSize,
				'font-family' : options.msgFontFamily,
				'color' : options.msgFontColor,
				'text-align' : options.msgTextAlign,
				'width' : $this.width(),
				'opacity' : 0
			};
			jqEasyCounterMsg.css(jqEasyCounterMsgStyle);
			// append counter element to DOM
			jqEasyCounterMsg[options.msgAppendMethod]($this);
			
			// bind events to this element
			$this
				.bind('keydown keyup keypress', doCount)
				.bind('focus paste', function(){setTimeout(doCount, 10);})
				.bind('blur', function(){jqEasyCounterMsg.stop().fadeTo( 'fast', 0);return false;});
			
			function doCount(){
				var val = $this.val(),
					length = val.length
				
				if(length >= options.maxChars) {
					val = val.substring(0, options.maxChars); 				
				};
				
				if(length > options.maxChars){
					// keep scroll bar position
					var originalScrollTopPosition = $this.scrollTop();
					$this.val(val.substring(0, options.maxChars));
					$this.scrollTop(originalScrollTopPosition);
				};
				
				if(length >= options.maxCharsWarning){
					jqEasyCounterMsg.css({"color" : options.msgWarningColor});
				}else {
					jqEasyCounterMsg.css({"color" : options.msgFontColor});
				};
				
				jqEasyCounterMsg.html('Characters: ' + $this.val().length + "/" + options.maxChars);
                jqEasyCounterMsg.stop().fadeTo( 'fast', 1);
			};
        });
    }
});

})(jQuery);
