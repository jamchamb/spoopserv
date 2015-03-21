from flask import Flask, render_template, g, request, jsonify, abort
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

@app.route('/ghost/', methods=['POST'])
@app.route('/ghost/<id>/', methods=['GET'])
def ghost(id=None):
    if request.method == 'POST':
        try:
            result = g.db_client.add_ghost(
                request.form['name'],
                request.form['user'],
                request.form['drawable'],
                [float(request.form['longitude']), float(request.form['latitude'])]
            ).dictify()
        except ValueError:
            abort(400)
            
        return jsonify(ghost=result)
    else:
        result = g.db_client.get_ghost(id).dictify()
        
        return jsonify(ghost=result)

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

@app.route("/test/")
def test_page():
    if app.debug == True:
        return render_template('test.html')
    else:
        abort(404)

