from flask import Flask, render_template, g
from client import SpoopedClient, Ghost
from util import NegativeFloatConverter
import json

app = Flask(__name__)

app.url_map.converters['float'] = NegativeFloatConverter

@app.before_request
def before_request():
    g.db_client = SpoopedClient()

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/ghost/<id>/', methods=['GET','POST'])
def ghost(id):
    return str(g.db_client.get_ghost(id))

@app.route("/ghosts/")
def ghosts():
    ghosts = g.db_client.get_ghosts()
    result = ""
    for ghost in ghosts:
        result += str(ghost) + "<br/>\n"
    return result

@app.route("/ghosts/near/<float:lon>/<float:lat>/")
def ghosts_near(lon, lat):
    return str(g.db_client.get_ghosts_near(lon,lat))

if __name__ == '__main__':
    app.run(debug=True)
