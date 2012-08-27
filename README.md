ImageControl
=================

Welcome ! 
ImageControl is a PHP Library using GD which will help you to manipulate images.
This Librarie is in constant evolution. This is the very early stage of it's life.

1) Usage with Symfony 2
--------------------------------

You only need to add this on your deps files :

[ImageControl]
    git=http://github.com/DavidPuleri/ImageControl.git

and install your vendor as you would do on any Symfony 2 project.

2) Usage independently
---------------------------------

    git clone http://github.com/DavidPuleri/ImageControl.git
    cd ImageControl
    rm -rf .git

Then you will need to autoload your class with spl_autoload_register. See 
bootstrap.php for a working example.


2) How to use
---------------------------------

    
    <?php
    use ImageControl\Load;
    use ImageControl\Format\Jpg;

    $loader = new Load('image-big-size.jpg');
    $loader->setKeepOriginal(false); 

    $homepage = new Jpg();
    $homepage->setWidth(567);

    $thumbnail = new Jpg();
    $thumbnail->setHeight(157);

    $loader->prepareThumbnail($homepage, 'image-homepage.jpg');
    $loader->prepareThumbnail($thumbnail, 'image-thumb.jpg');

    $loader->saveThumbnail();

You can define both width and height, but the ratio won't be kept.
That's about it for now. Very simple to use. More to come :)


3) Contribute
---------------------------------
Do not hesite to contribute or comment ! Thanks !