from mongoengine import *

class SpoopedClient(object):

    def __init__(self, db='spoopdb', host=None, port=None):
        """Create a new client."""

        connect(db, host=host, port=port)

    def add_ghost(self, ghost_json):
        """Add ghost."""
        ghost = Ghost(**ghost_json)
        ghost.save()
        return ghost
        
    def get_ghost(self, id):
        """Get ghost by ID."""
        return Ghost.objects.get(id=id)

    def get_ghosts(self):
        """Get all ghosts."""
        return Ghost.objects

    def get_ghosts_near(self, longitude, latitude):
        """Get ghosts near a given location."""
        return Ghost.objects(__raw__={'loc':{'$nearSphere':{'$geometry':{'type':'Point', 'coordinates': [longitude, latitude]}, '$maxDistance': 25}}})

class Ghost(Document):
    name = StringField(required=True, max_length=32) # ghost's name
    user = StringField(required=True, max_length=32) # creator's username
    drawable = StringField(required=True, max_length=64) # ghost image name
    loc = PointField(required=True) # location (geojson point coordinate)

    def dictify(self):
        return {'id': str(self.id), 'name': self.name, 'user': self.user, 'drawable': self.drawable, 'loc': self.loc}
    
    def __str__(self):
        return "\"%s\" by %s" % (self.name, self.user)

    def __repr__(self):
        return "Ghost(name=%r, user=%r, drawable=%r, loc=%r)" % (self.name, self.user, self.drawable, self.loc)
