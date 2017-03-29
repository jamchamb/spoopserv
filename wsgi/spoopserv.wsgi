activate_this = '/var/www/spoopserv/venv/bin/activate_this.py'
execfile(activate_this, dict(__file__=activate_this))

from spoopserv import app as application
