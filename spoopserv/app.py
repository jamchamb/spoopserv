from flask import Flask, render_template
app = Flask(__name__)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/ghost/<id>', methods=['GET','POST'])
def ghost(id):
    return "a single ghost"

@app.route("/ghosts")
def ghosts():
    return "all ghosts"

@app.route("/ghosts/near/<float:lon>/<float:lat>/")
def ghosts_near(lon, lat):
    return "Ghosts near " + str(lon) + "," + str(lat)

if __name__ == '__main__':
    app.run(debug=True)
