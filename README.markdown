# A/B Split Test

Version: 1.11
Author: Mark Lewis <mark@casadelewis.com>  
Contributor: Nils Werner <nils.werner@gmail.com>  
Build Date: 10 February 2012
Requirements: Symphony 2.0.6  

Installation
-------------------------------------------------------------------------------

1. Upload the 'ab_split_test' folder in this archive to your Symphony
   'extensions' folder.
   
2. Enable it by selecting the "A/B Split Test" item under Extensions, choose Enable
   from the with-selected menu, then click Apply.

3. Attach the event 'A/B Split Test' to the Pages you want to test.

4. Utilize the `<ab-split-test />` node to make changes in your page's content. The extension will randomly serve the page without the parameter (original) and with the parameter set to "b" (variation).
  
5. Utilize tracking software to observe behavior for original and variation pages. You'll probably need to add custom values to your tracking snippet to fetch A/B values.
   
6. After testing period, detach Event from Pages and make appropriate changes to content based on the results.

7. To run another test, click "Reset assigns" button in Preferences dialog to reassign your users to new groups.