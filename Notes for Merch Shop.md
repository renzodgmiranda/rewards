Search box change query through buttons:

When selecting buttons, pass a different query under the 
appropriate model named from the buttons.

Also pass a different component when that happens

Possibly use an if statement and a event listener to check the active button
when active, activate the div section with the appropraite formating


Modal and wire:navigate attribute on <a> elements:
The use of wire:navigate is so that we cut the loading times per nav link and make it look like a single page application. 
To apply it to a <a> element:

    <a wire:navigate href="example route/url"></a>

However haviing something like this disables the planned modal help function
when changing links, It does not identify that it has changed back to a certain page.
For example, the modal is called to the dashboard.blade.php and when you press the help function in dashboard, it shows up
with wire:navigate, when I go to another page like profile page, then go back to dashboard and click help, the modal doesnt show up.
There was an issue with the admin reroute as well when you press "To Admin Panel" it messes up the dropdown nav links that automatically shows it up but the 
one under the profile photo drop down goes out of screen.
Will revisit this issue so we can still have the wire:navigate attribute as SPA (single page application) feels smoother.

I used <x-nav-link> for all the nav links that should be under the views/components/nav-link.blade.php
I commented out the wire:navigate feature for now
