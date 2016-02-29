# dashboard-q

Dashboard-q is a homelab dashboard with qBittorrent, PRTG and forecast.io integration.

Extract to your webserver and create/edit the "config.ini" file with the proper settings in the same directory as "requests.php". You'll also need to put your own ips in "home.php".
Your config file should look like this: 

    username = "myuser"
    password = "mypass"
    qbittorrent_url = "https://192.168.0.0:8080"
    prtg_map = "https://prtg-server/public/mapshow.htm?id=1234&mapid=123456789123456789"
    forecast_key = "myapikey"
    forecast_lat = "12"
    forecast_long = "-12"

dashboard-q is built using:
 * [Nice admin template](http://bootstraptaste.com/nice-admin-bootstrap-admin-html-template/?download=true)
 * [tobias redmann's forecast.io php api](https://github.com/tobias-redmann/forecast.io-php-api)
 * [darkskyapp's Skycons](https://github.com/darkskyapp/skycons)


## Screenshot

![Not found](/screenshots/home.png?raw=true "Optional Title")

## License
Distributed under the MIT License.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
