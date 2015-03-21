from unittest import TestCase

from spoopserv import SpoopedClient, Ghost

class TestGhost(TestCase):
    
    def test_add_ghost(self):
        client = SpoopedClient('spoopdb_test')

        new_ghost = client.add_ghost('Testy', 'admin', 'ghost_one_teal', [-10.123, 10.123])

        self.assertTrue(isinstance(new_ghost, Ghost))

        self.assertTrue(new_ghost.name == 'Testy')
        self.assertTrue(new_ghost.user == 'admin')
        self.assertTrue(new_ghost.drawable == 'ghost_one_teal')
        # something about the GeoJSON point here ;)

        self.assertTrue(client.get_ghost(str(new_ghost.id)) == new_ghost)

        new_ghost.delete()
