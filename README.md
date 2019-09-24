# Tiny SliTaz

Build your configuration from binary packages.


## Tiny SliTaz goals

Useful software, expansible, easy to configure, runs fully in RAM, simple, light
and fast for minimum hardware resources, i.e. fits on one floppy disk (IDE disk
optional), runs on a 386SX processor and needs as little memory as possible
(currently 4MB with a 2.6.14 Kernel).
[Example](http://doc.slitaz.org/en:guides:pxe#why-use-pxe-the-vnc-example)


## Why this builder?

Tiny SliTaz should be as small as possible. Only the necessary software is kept.
The package manager is run using this website.


## How is it built?

Tiny SliTaz uses a Linux Kernel with an embedded filesystem. An extra initramfs
can also be loaded with the configuration files and extra packages.

The initramfs is based on [uClibc](http://uclibc.org/) (instead of glibc) and
busybox with its config files and filesystem tree from `base-tiny` package you
can find in the `wok-tiny` repository.
