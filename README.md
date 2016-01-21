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

### Append to app/config/config.yml

```
...
imports:
    - { resource: '@MMMediaBundle/Resources/config/config.yml' }
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


### Create web/media folder to store images

```
...
shell: mkdir PROJECT_ROOT/web/media
...
```

### Use MMMediaBundle in your Entities
You need to use the MediaSortable Entity of this bundle to have sortable Media.
For a collection of media, use an unidirectional manyToMany-association and for single media an
unidirectional oneToOne. To avoid garbage in your database, make sure to set the orphanRemoval flag.


#### eg. yaml configuration for single media:
```
...
    oneToOne:
        titleImage:
            targetEntity: MandarinMedien\MMMediaBundle\Entity\MediaSortable
            cascade:
              - persist
              - remove
...
```


#### eg. yaml configuration for media collection:
```
...
    manyToMany:
        medias:
            targetEntity: MandarinMedien\MMMediaBundle\Entity\MediaSortable
            orderBy: { 'position': 'ASC' }
            joinColumn:
                name: media_sortable_id
                referencedColumnName: id
            cascade:
                - persist
                - remove
            orphanRemoval: true
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

### FormType Options

```
...

    $builder          
        ->add('medias', 'mmmedia_upload_collection', array(
            
            // optional: configure allowed filetypes by file-extensions 
            'allowed_filetypes' => array( 
                '.jpg', '.png', '.gif'
            )
            
        ));

...
```
