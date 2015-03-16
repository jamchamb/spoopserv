from setuptools import setup

def readme():
    with open('README.rst') as f:
        return f.read()

setup(name='spoopserv',
    version='0.1',
    description='Server for Spooped app.',
    long_description=readme(),
    url='http://github.com/jamchamb/spoopserv',
    author='James Chambers',
    author_email='jameschambers2@gmail.com',
    license='',
    packages=['spoopserv'],
    install_requires=[
        'Flask',
        'pymongo'
    ],
    zip_safe=False)
