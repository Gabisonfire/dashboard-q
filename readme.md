# dashboard-q

Dashboard-q is a homelab dashboard with qBittorrent/Transmission, PRTG and forecast.io integration.

## Installation

Extract to your webserver and access the index page. You will be redirected to the setup and the bookmarks page.
Then, in your browser, navigate to the root of the directory (ex: http://localhost/dahboard-q) and you will be prompted with the settings page for your initial setup.

The time display is based on your php settings. Set the timezone in your php.ini file.

Secure your webserver to deny-all on the config.ini, otherwise, anyone can view your api-key, torrent_username, and torrent_password simply by appending /config.ini to the end of the url.

Make sure your config.ini and the bookmarks.dat files are writeable by your webserver otherwise the settings page won't work.

### forecast.io API

Make sure to register to https://darksky.net for a free account, to use the forecast APIs.

### Dependencies

php-curl is needed, for integration with either Transmission or qBittorrent to display torrent status in the homepage. Be sure to have it installed and enabled, for the php version of your choice (i.e. php7.1-curl).

## Bookmarks

Bookmarks can be set in the "bookmarks.dat" file or from the UI. Here's an example of the content:

	[Media]
	icon=icon_plus
	isCategory=true

    [qBittorrent]
	url=https://192.168.0.0:8080
	icon=icon_cloud-download_alt
	iframe=true

	[Plex]
	url=https://192.168.0.0:32400/web/index.html
	icon=arrow_triangle-right_alt2
	iframe=false

![Not found](/screenshots/bookmarks.png?raw=true "Bookmarks")


**Leave a blank line between each definition.**

 * url: The url you wish to reach
 * icon: The icon of the bookmark, available icons are displayed here: https://www.elegantthemes.com/blog/resources/elegant-icon-font, Look under "Complete List Of Class Names".
 * iframe: Can be true or false. "true" will open the page in the current window while "false" will open it in a new tab. You may encounter problem with "true" as some softwares won't allow loading in an iframe. Sometimes, you just need to visit the page once to accept the self-signed certificate.
 * isCategory: Set to "true" to make this section behave like a category header, anything below it will fall under this category until it finds another one.


dashboard-q is built using:
 * [Nice admin template](http://bootstraptaste.com/nice-admin-bootstrap-admin-html-template/?download=true)
 * [tobias redmann's forecast.io php api](https://github.com/tobias-redmann/forecast.io-php-api)
 * [darkskyapp's Skycons](https://github.com/darkskyapp/skycons)


## Screenshot

![Not found](/screenshots/home.png?raw=true "Home")
![Not found](/screenshots/categories.png?raw=true "Categories")

## Future plans

- Zabbix integration

## DISCLAIMER
This is in no mean built to be accessible from the internet. Expose at your own risks.

## License
Distributed under the MIT License.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
