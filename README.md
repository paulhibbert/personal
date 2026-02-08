# Personal Website (WIP)

## Based on Laravel Livewire Starter Kit (Livewire 3)

Naturally there is some hacking around with the starter kit and it starts with the `welcome.blade.php`.

### Adding inline Livewire components

As long as the blade file has `@livewireStyles` and `@livewireScripts` adding an inline livewire component is as simple as dropping `<livewire:weather defer/>` into the layout. This looks for a component at `App/Livewire/Weather.php`. An inline component can return just text if its used to render the content of an element, so somewhat like `@inject` blade directive. Or it can return html or even Blade content.

```php
<?php
class Weather extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="mb-2">
            {{ $this->fetchLatestWeatherObservation() }}
        </div>
        HTML;
    }

    protected function fetchLatestWeatherObservation(): string
    {
}
```

## Laravel Folio

Folio is a package from Laravel which provides routing automatically (via a catch all route) based simply on the directory structure. The path is provided in the FolioServiceProvider `Folio::path(resource_path('views/folio'))` so it provides a simple way to incorporate stand-alone pages from past projects and experiments or indeed new demos using the new Livewire 4 single file components. Each folio page is just a blade file (which does not necessarily even have to have any blade directives in it).

So a file `resources/views/folio/demos/cv.blade.php` will be available at `http://personal.test/demos/cv` for example if using locally with Herd. In that example the file is just an html page, completely stand-alone.

Its also possible to have named routes with Folio so that internal links become possible such as `route('demos.index')` which uses the `resources/views/folio/demos/index.blade.php` which is a blade component using one of the layouts provided in the starter kit.

```php
<?php
use function Laravel\Folio\name;
name('demos.index');
?>

<x-layouts.app.simple title="Demos">
    <x:slot:menu
    ...        
    </x:slot>

    <flux:main>
    ...
    </flux:main>
</x-layouts.app.simple>
```

## Upgraded to Livewire 4

Livewire 4 is largely/completely(?) backwards compatible with version 3 so after updating the composer package the livewire components from the starter kits continued to work as before (classes in app/Livewire and the layout in blade components). At the time of writing the Livewire 4 docs do not mention inline components any more, but these continue to work exactly as before.

However the new default is single-file components such as `resources\views\components\weather-data.blade.php` which contains an anonymous PHP class which extends the Livewire Component class as well as the layout and any assets and scripts required for the component.

```php
<?php
use Livewire\Component;
new class extends Component {};
?>
<div>
    <canvas id="barChartCanvas"></canvas>
</div
@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
@endassets
<script>
    Livewire.hook('morphed',  ({ el, component }) => {
        ...
    });
</script>
```

### Converting the starter kit dashboard to a Livewire 4 component

- convert the route in web.php from a standard view to a livewire route

```php
Route::view('dashboard', 'dashboard')
    ->name('dashboard');
// becomes
Route::livewire('dashboard', 'dashboard')
    ->name('dashboard');
```

- replace `resources/views/dashboard.blade.php` with `resources/views/components/dashboard.blade.php` and update the livewire config file to look for components in this location.

Now the new blade file is a single-file component and can also use new features such as islands to allow the different dashboard panels to be loaded separately and asynchronously (including re-using the weather-data component).

## Hacking a docs repository with Laravel, Folio, Livewire, Markdown files and Commonmark

Obviously not going to be a full blown CMS but how far can we get?

- create a Docs folder under the app directory to store markdown files

  - [simple features package](https://github.com/paulhibbert/personal/blob/main/app/Docs/code/features.md)
  - [some links](https://github.com/paulhibbert/personal/blob/main/app/Docs/learning/french.md) to French language learning resources
  - [Extracts from the Will](https://github.com/paulhibbert/personal/blob/main/app/Docs/genealogy/will.md) of Thomas Stopford of Audenshaw 1766-1834

- map a Storage disk to this directory so any content can be found programmatically

```php
    'docs' => [
        'driver' => 'local',
        'root' => app_path('Docs'),
        'serve' => true,
        'throw' => false,
        'report' => false,
        'read-only' => true,
    ],
```

- chose to create a topics model using [Sushi](https://github.com/calebporzio/sushi) the topics in the model array match the folders in the docs directory. The model has a static function `getArticlesForTopic` to get the names of the articles from the files in the folder for that topic.
- needing an entry point into the docs, create a folio index page in the `views/folio/topics` directory, this will be the only entry in this folio directory as the articles will be loaded into the same page by clicking on a menu created by looping through the topics and for each topic retrieving the articles list.
- the topics index page is a blade component using a layout with two slots, a named slot for menu in the sidebar and then the main slot for the rest of the page.
- in the main slot of the topics index page is a livewire component (inline) which will load a random article when the page is loaded but which will also load a selected article when the menu item is clicked. Flux components are provided as part of the starter kit (the free ones anyway).

```html
<flux:main>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex flex-col gap-4">
            <livewire:load-article defer />
        </div>
    </div>
</flux:main>
```

- the menu is initialised with JavaScript and emits a livewire event when clicked which requires absolutely no scaffolding to process on the backend other than a single PHP annotation on the public method in the Component class.

```JS
function init() {
    const topicLinks = document.querySelectorAll('.topic_link');
    topicLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            let articleName = link.classList[link.classList.length - 1].replace('article_', '')
                .replaceAll('_', ' '); // Extract article name from class
            let topic = link.classList[link.classList.length - 2].replace('topic_', '').replaceAll(
                '_', ' '); // Extract topic name from class
            Livewire.dispatch('topic-clicked', {
                path: topic,
                name: articleName
            });
        });
    });
};
```

- in the Livewire component the method is as simple as

```php
#[On('topic-clicked')]
public function loadSelectedArticle(string $path, string $name)
{
    $this->articlePath = "{$path}/{$name}.md";
    $this->render();
}
public function render()
{
    return <<<'BLADE'
        <div>
            {!! $this->fetchArticle() !!}
        </div>
    BLADE;
}
```

- rendering the markdown as html is done using [Commonmark](https://github.com/thephpleague/commonmark) but entirely via the inbuilt Laravel `Str::markdown()` method. At the moment the configuration passed into the markdown method is a WORK IN PROGRESS and adds tailwind classes for (some) headings, external links, lists, blockquotes, and standard paragraphs.

Commonmark takes a fenced code block and wraps it with a `<pre>` element, any classes passed into the FencedCode class as configuration are applied to the code element and so are ignored by the browser (believe this element and its attributes are probably in place for front end javaScript to intercept).

```php
return new HtmlElement(
    'pre',
    [],
    new HtmlElement('code', $attrs->export(), Xml::escape($node->getLiteral()))
);
```

For the moment I have added some basic css styling to the pre element.
