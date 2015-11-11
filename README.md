# MMMediaBundle

Append to app/AppKernel.php

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

Append to App/config/routing.yml

```
...
mm_media:
    resource: "@MMMediaBundle/Resources/config/routing.yml"
    prefix:   /mmmedia
...
```