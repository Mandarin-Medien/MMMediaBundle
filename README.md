# MMMediaBundle

### Append to app/AppKernel.php

```
...
    public function registerBundles()
    {
        $bundles = array(
            ...
            new MandarinMedien\MMMediaBundle\MMMediaBundle(),
            ...
            );
    ....
    }
...
```

### Append to App/config/routing.yml

```
...
mm_media:
    resource: "@MMMediaBundle/Resources/config/routing.yml"
    prefix:   /mmmedia
...
```

### Add all needed Assets to your layout
To make the MMMediaBundle-UploadWidget work properly you need to add the necessary CSS and the JS files.
Your can just copy this part below or add @mmmedia_assets_css and @mmmedia_assets_js into your asset calls.

#### Twig-Example:

```
...
    {% stylesheets '@mmmedia_assets_css' %}
    <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}

    {% javascripts '@mmmedia_assets_js' %}
    <script src="{{ asset_url }}"></script>
    {% endjavascripts %}
...
```