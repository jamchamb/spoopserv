from flask import Flask, render_template, g, jsonify
from .client import SpoopedClient, Ghost
from .util import NegativeFloatConverter

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
    return jsonify(ghost=g.db_client.get_ghost(id).dictify())

@app.route("/ghosts/")
def ghosts():
    results = []
    for ghost in g.db_client.get_ghosts():
        results.append(ghost.dictify())
        
    return jsonify(ghosts=results)

@app.route("/ghosts/near/<float:lon>/<float:lat>/")
def ghosts_near(lon, lat):
    results = []
    for ghost in g.db_client.get_ghosts_near(lon,lat):
        results.append(ghost.dictify())

    return jsonify(ghosts=results)
