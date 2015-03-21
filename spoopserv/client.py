from mongoengine import *

class SpoopedClient(object):

    def __init__(self, host=None, port=None):
        """Create a new client."""

        connect('spoopdb', host=host, port=port)

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
    name = StringField(required=True) # ghost's name
    user = StringField(required=True) # creator's username
    drawable = StringField(required=True) # ghost image name
    loc = PointField(required=True) # location

    def dictify(self):
        return {'name': self.name, 'user': self.user, 'drawable': self.drawable, 'loc': self.loc}
    
    def __str__(self):
        return "\"%s\" by %s" % (self.name, self.user)

    def __repr__(self):
        return "Ghost(name=%r, user=%r, drawable=%r, loc=%r)" % (self.name, self.user, self.drawable, self.loc)
