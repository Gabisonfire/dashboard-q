# dashboard-q

Dashboard-q is a homelab dashboard with qBittorrent/Transmission, PRTG and forecast.io integration.

## Installation

Extract to your webserver and create a "bookmarks.dat" file in the root direcotry.
Then, in your browser, navigate to the root of the directory (ex: http://localhost/dahboard-q) and you will be prompted with the settings page for your initial setup.

The time display is based on your php settings. Set the timezone in your php.ini file.

Secure your webserver to deny-all on the config.ini, otherwise, anyone can view your api-key, torrent_username, and torrent_password simply by appending /config.ini to the end of the url.

## Bookmarks

Bookmarks must be set in the "bookmarks.dat" file. Here's an example:

    [qBittorrent]
	url=https://192.168.0.0:8080
	icon=icon_cloud-download_alt
	iframe=true
	
	[Plex]
	url=https://192.168.0.0:32400/web/index.html
	icon=arrow_triangle-right_alt2
	iframe=false
	
**Leave a blank line between each definition.**
	
 * url: The url you wish to reach
 * icon: The icon of the bookmark, available icons are displayed here: https://www.elegantthemes.com/blog/resources/elegant-icon-font, Look under "Complete List Of Class Names".
 * iframe: Can be true or false. "True" will open the page in the current window while "false" will open it in a new tab. You may encounter problem with "true" as some softwares won't allow loading in an iframe. Sometimes, you just need to visit the page once to accept the self-signed certificate.

	
dashboard-q is built using:
 * [Nice admin template](http://bootstraptaste.com/nice-admin-bootstrap-admin-html-template/?download=true)
 * [tobias redmann's forecast.io php api](https://github.com/tobias-redmann/forecast.io-php-api)
 * [darkskyapp's Skycons](https://github.com/darkskyapp/skycons)


## Screenshot

![Not found](/screenshots/home.png?raw=true "Home")

 
## License
Distributed under the MIT License.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
