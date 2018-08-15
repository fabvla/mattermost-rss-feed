# RSS- and Atom-Feed Integration Service for Mattermost

This integration service posts RSS feeds into specific Mattermost channels by formatting output from html to text
via [Mattermost's incoming webhooks](https://docs.mattermost.com/developer/webhooks-incoming.html). It can also be managed through [slash-commands](https://docs.mattermost.com/developer/slash-commands.html).

## Requirements

To run this integration you need:

1. A **network connected device running PHP > 5.6** like Raspberry Pi or any other Linux device which supports PHP and the required packages via composer
2. A **[Mattermost account](http://www.mattermost.org/)** where [incoming webhooks are enabled](https://docs.mattermost.com/developer/webhooks-incoming.html)

## Installation

The following procedure shows how to install this project on a Linux device running Ubuntu.
The following instructions work behind a firewall as long as the device has access to your Mattermost instance.

To install this project using a Linux-based device, you will need PHP 5.6 or a compatible version.
Other compatible operating systems and Python versions should also work.

Here's how to start:

1. **Set up your Mattermost instance to receive incoming webhooks**
    1. Log in to your Mattermost account. Click the three dot menu at the top of the left-hand side and go to  
        **Account Settings** > **Integrations** > **Incoming Webhooks**.
    2. Under **Add a new incoming webhook** select the channel in which you want Feed notifications to appear, then click **Add** to create a new entry.
    3. Copy the contents next to **URL** of the new webhook you just created (we'll refer to this as `https://<your-mattermost-webhook-URL>`).

2. **Set up this project to run on your Linux device**
    1. Set up a **Linux Ubuntu** server either on your own machine or on a hosted service, like AWS (on Windows works as well).
    2. **SSH** into the machine, or just open your terminal if you're installing locally.
    3. Confirm **PHP 5.6+** or a compatible version is installed by running:  
        `php --version`
    4. Clone this GitHub repository:  
        `git clone https://github.com/fabvla/mattermost-rss-feed.git`  
        `cd mattermost-rss-feed`
    5. Copy sample file `config.php.sample`:  
        `cp config.php.sample config.php`
    6. Edit `config.php` to suit your requirements:  
        `nano config.php`  
        Save your changes (F2) and exit nano (CRTL-X)
    7. Setup environment:  
         `composer install`
    8. Test the the feed fetcher:  
         `php feedfetcher.php`  
        You should see your feeds scrolling through. Check your configured Mattermost channel for the new feeds.  
        If everything works fine:  
    9. Add feedfetcher on crontab, once a day, ie at 9 am like:  
         `crontab -e`  
        than add a line like:  
         `0 9 * * * php /opt/applications/mattermost-rss-feed/feedfetcher.php > /opt/applications/mattermost-rss-feed/feedfetcher.log`


