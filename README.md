# What is Foto-Diretta?

![run-tests](https://github.com/danieleugoletti/foto-direttta/workflows/run-tests/badge.svg)

Foto-Diretta wants to be an aggregator of live events (Facebook, Instagram, YouTube or other channels).
The focus of the project is on events relating to photography, but it can be used for any type of topic.

The application is developed with [Laravel](https://laravel.com/), [LiveWire](https://laravel-livewire.com/) and [Tailwind CSS](https://tailwindcss.com/).

A lot of attention is paid to privacy, for this reason the event proposals are anonymous.

It does not store any user data, no statistical tracking is performed.

Foto-Diretta in English means:
```
Foto -> Photo
Diretta -> Live events
```

## Why?

During COVID-19 lockdown spontaneous live photographic events flourished worldwide through different channels (Facebook, Instagram, YouTube, etc.). Too many not to miss out some we might really wanted to attend at.

What if you could check in advance the scheduled ones by your contacts or loved authors?

Anyone can stay tuned, search event by title, authors or date.

## How work

Foto-Diretta will be always updated: like Wikipedia, anyone can contribute and can propose a live event. No registration is necessary, the events will be showed after moderation by site administrators.

## Where Foto-Diretta is used?

Currently Foto-Diretta is used in these sites:
- [Foto-Diretta](https://fotodiretta.it): archive of photographic broadcasts for amateurs _(Italian language)_.

You are free to install Foto-Diretta and also use it for other subjects other than photography: please, report your installation via a pull request so that we can update the list.


# Requirements

See [Laravel Server Requirements](https://laravel.com/docs/7.x/installation#server-requirements)


# Installation

* Clone the repository: `git clone https://github.com/danieleugoletti/foto-diretta.git`
* Install dependencies: `composer install`
* Set the [Environment Configuration](https://laravel.com/docs/7.x/configuration)
* Create DB table: `php artisan migrate`

## Development

* Install dependencies: `npm install`
* Compile the css: `npm run dev`
* Seed DB with sample data: `php artisan db:seed`

# Roadmap

* Publish event reminder to social channel: facebook, twitter, instagram, telegram group
* New layout
* Permalink to event detail
* Add new type of events: live recording, exhibition, contest, postcast, youtube channel


# License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
