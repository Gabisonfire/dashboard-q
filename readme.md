# dashboard-q

Dashboard-q is a homelab dashboard with qBittorrent, PRTG and forecast.io integration.

## Installation

Extract to your webserver and create a "config.ini" file with the proper settings in the same directory as "requests.php" and a "bookmarks.dat" in the same directory as "index.php".
Your config file should look like this: 

	torrent_username = "myuser"
	torrent_password = "mypass"	
	torrent_url = "https://192.168.0.0:8080"
	prtg_map = "https://prtg-server/public/mapshow.htm?id=1234&mapid=123456789123456789"
	forecast_key = "myapikey"
	forecast_lat = "12"
	forecast_long = "-12"
	show_errors = true
	show_weather = false

The time is based on your php settings. Set the timezone in your php.ini file.

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
 * target: Can be true or false. "True" will open the page in the current window while "false" will open it in a new tab. You may encounter problem with "true" as some softwares won't allow loading in an iframe. Sometimes, you just need to visit the page once to accept the self-signed certificate.
	
	
dashboard-q is built using:
 * [Nice admin template](http://bootstraptaste.com/nice-admin-bootstrap-admin-html-template/?download=true)
 * [tobias redmann's forecast.io php api](https://github.com/tobias-redmann/forecast.io-php-api)
 * [darkskyapp's Skycons](https://github.com/darkskyapp/skycons)


## Screenshot

![Not found](/screenshots/home.png?raw=true "Optional Title")

## Changelog

 * 04-05-16: Moved bookmarks to a seperate file to ease updates.
 * 04-03-16: Added:
   * Time display to top bar
   * Better error display and messages
   * Ability to hide errors
   * Ability to disable weather
   * Changed some config terms (had to be done) for future uses.
 * 03-03-16: Added Dowload and upload speeds to the dashboard.
 * 03-01-16: Added error handling for requests(still needs some work).
 
## License
Distributed under the MIT License.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
