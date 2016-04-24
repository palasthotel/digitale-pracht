SCSS architecture
=================

@author Kim-Christian Meyer <kim.meyer@palasthotel.de>
@modified 2014-11-14

- This SCSS architecture is based on https://smacss.com, and modified to fit the needs of a typical news website. E.g. instead of modules we use namespaces here, and there is no state folder.

- Please prefix all classes with a namespace consisting of two letters and a hyphen, to prevent conflicts with third party modules. Example: .ph-menu-title

- Please be careful when choosing class names, don´t mind to be very precife if neccessary. Long class names only have an insignificant influence on page load when the page is GZIPped.

- The folling SCSS structure has some benefits, e.g. it makes it easy to 1) find the definition file of a class and 2) there is not much choice, where to create new scss files.

  /namespaced
   - this folder is named namespaces, because a class defined in a file here contains at least a part of its filename.
   If you have a class named .ph-menu-title, search for it in _ph-menu-title.scss. If that file doesn´t exist, search in _ph-menu.scss. Again, if that file doesn´t exist, search in _ph.scss. If you want to create a class named .ph-menu-title and don´t know, where to put it: consider if its worth creating a separate _ph-menu-title.scss. If that class would be very small, consider putting it inside a file named _ph-menu.scss.

  /styleguide
    - includes style definitions you would find in a design guide, e.g. animation constants, breakpoints, font families, font sizes, grid dimensions

  /no-output
    - contains all SCSS files, which don´t create any CSS output, e.g. mixins or constants

  /not-namespaced
    - this is where all the rest goes. Sometimes you have to redefine CMS classes, which don´t follow a namespace convention, so they belong here. Another example is normalice.scss or print.scss, because they contain lots of different classes. If you must use another structure for some modules etc., that´s also the place where you can feel free to build whatever you want.

- State classes don´t need to be prefixed, because they only work in combination with another class, which is prefixed. Example:
  <div class="ph-floating-header is-visible">…

  The definition of .is-visible is never standalone, it always happens close to the .ph-floating-header definition and looks like this:

  .ph-floating-header {
    display: none;

    &.is-visible {
      display: block;
    }
  }
