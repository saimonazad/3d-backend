(function ($) {
  'use strict';

  $.fn.rtWpVGallery = function () {
    this._item = $(this);
    this._target = this._item.parent();
    this._product = this._item.closest('.product');
    this._default_gallery_images = this.data('default-images') || [];
    this._variation_form = this._product.find('.variations_form');
    this._product_id = this._variation_form.data('product_id');
    this._is_variation_product = !!this._variation_form.length;
    this._is_bundle_product = this._item.hasClass('rtwpvg-product-type-bundle');
    this._slider = $('.rtwpvg-slider', this._item);
    this._thumbnail = $('.rtwpvg-thumbnail-slider', this._item);
    this.initial_load = true;
    this.is_vertical = !!rtwpvg.is_vertical;

    this.removeLoading = function () {
      this._item.removeClass('loading-rtwpvg');
    };

    this.addLoading = function () {
      this._item.addClass('loading-rtwpvg');
    };

    this.loadDefaultGalleryImages = function () {
      if (this._is_variation_product && !this._default_gallery_images.length) {
        var that = this;
        wp.ajax.send('rtwpvg_get_default_gallery_images', {
          data: {
            product_id: this._product_id
          },
          success: function success(data) {
            that._default_gallery_images = data;

            that._item.trigger('rtwpvg_default_gallery_image_loaded');
          },
          error: function error(e) {
            that._default_gallery_images = [];

            that._item.trigger('rtwpvg_default_gallery_image_loaded');
          }
        });
      }
    };

    this.loadSlider = function () {
      var that = this;

      try {
        if (this._slider.hasClass('slick-initialized')) {
          this._slider.slick('unslick');
        }
      } catch (e) {}

      this._slider.off('init');

      this._slider.off('beforeChange');

      this._slider.off('afterChange');

      this._item.trigger('rtwpvg_before_init');

      this._slider.on('init', function (e) {
        if (that.initial_load) {
          that.initial_load = false;
        }
      }).on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        that._thumbnail.find('.rtwpvg-thumbnail-image').not('.slick-slide').removeClass('current-thumbnail').eq(nextSlide).addClass('current-thumbnail');
      }).on('afterChange', function (event, slick, currentSlide) {
        that.stopVideo(that._slider);
        that.loadZoom(currentSlide);
      }).slick();

      this._thumbnail.find('.rtwpvg-thumbnail-image').not('.slick-slide').first().addClass('current-thumbnail');

      this._thumbnail.find('.rtwpvg-thumbnail-image').not('.slick-slide').each(function (i, item) {
        $(item).find('div, img').on('click', function (event) {
          event.preventDefault();
          event.stopPropagation();

          that._slider.slick('slickGoTo', i);
        });
      });

      if (rtwpvg.is_vertical && rtwpvg.enable_thumbnail_slide) {
        $(window).on('resize', that.setThumbnailPositionOnResize());

        this._slider.on('setPosition', that.setThumbnailHeightOnSetPosition());

        this._slider.on('afterChange', function () {
          that.setThumbnailHeight();
        });
      }

      var thumbnails = this._thumbnail.find('.rtwpvg-thumbnail-image');

      if (parseInt(rtwpvg.thumbnails_columns) < thumbnails.length && rtwpvg.enable_thumbnail_slide) {
        thumbnails.removeClass('current-thumbnail');
        this.loadThumbnailSlider();
      } else {
        this._slider.slick('slickSetOption', 'asNavFor', null, false);
      }

      setTimeout(function () {
        that._item.trigger('rtwpvg_slider_init');
      }, 1);
      setTimeout(function () {
        that.removeLoading();
      }, 1);
    };

    this.stopVideo = function (item) {
      $(item).find('iframe, video').each(function () {
        var tag = $(this).prop("tagName").toLowerCase();

        if (tag === 'iframe') {
          var src = $(this).attr('src');
          $(this).attr('src', src);
        }

        if (tag === 'video') {
          $(this)[0].pause();
        }
      });
    };

    this.setThumbnailHeight = function () {
      if (this.is_vertical) {
        if (this._slider.slick('getSlick').$slides.length > 1) {
          this._thumbnail.height(this._slider.height());
        } else {
          this._thumbnail.height(0);
        }
      } else {
        this._thumbnail.height('auto');
      }

      if (this._thumbnail.hasClass('slick-initialized')) {
        this._thumbnail.slick('setPosition');
      }
    };

    this.setThumbnailHeightOnSetPosition = function () {
      var that = this;
      this.setThumbnailHeight();
      return _.debounce(function () {
        that.setThumbnailHeight();
      }, 401);
    };

    this.setThumbnailPositionOnResize = function () {
      var that = this;
      that.setThumbnailPosition();
      return _.debounce(function () {
        that.setThumbnailPosition();
      }, 400);
    };

    this.setThumbnailPosition = function () {
      if (rtwpvg.is_vertical) {
        if (window.matchMedia("(max-width: 768px)").matches || window.matchMedia("(max-width: 480px)").matches) {
          this.is_vertical = false;

          this._item.removeClass('rtwpvg-thumbnail-position-left rtwpvg-thumbnail-position-right rtwpvg-thumbnail-position-bottom');

          this._item.addClass('rtwpvg-thumbnail-position-bottom');

          this._slider.slick('setPosition');
        } else {
          this.is_vertical = true;

          this._item.removeClass('rtwpvg-thumbnail-position-left rtwpvg-thumbnail-position-right rtwpvg-thumbnail-position-bottom');

          this._item.addClass('rtwpvg-thumbnail-position-' + rtwpvg.thumbnail_position);

          this._slider.slick('setPosition');
        }
      }
    };

    this.loadThumbnailSlider = function () {
      var that = this;

      try {
        if (this._thumbnail.hasClass('slick-initialized')) {
          this._thumbnail.slick('unslick');
        }
      } catch (e) {}

      this._thumbnail.off('init');

      this._thumbnail.on('init', function () {}).slick();

      setTimeout(function () {
        that._item.trigger('rtwpvg_thumbnail_slider_init');
      }, 1);
    };

    this.callZoom = function () {
      var currentSlide = this._slider.slick('slickCurrentSlide');

      this.loadZoom(currentSlide);
    };

    this.loadZoom = function (currentSlide) {
      if (!rtwpvg.enable_zoom) {
        return;
      }

      var galleryWidth = parseInt(this._target.width()),
          zoomEnabled = false,
          zoomTarget = this._slider.slick("getSlick").$slides.eq(currentSlide);

      $(zoomTarget).each(function (index, element) {
        var image = $(element).find('img');

        if (parseInt(image.data('large_image_width')) > galleryWidth) {
          zoomEnabled = true;
          return false;
        }
      });

      if (!$.fn.zoom) {
        return;
      }

      if (zoomEnabled) {
        var zoom_options = $.extend({
          touch: false
        }, wc_single_product_params.zoom_options);

        if ('ontouchstart' in document.documentElement) {
          zoom_options.on = 'click';
        }

        zoomTarget.trigger('zoom.destroy');
        zoomTarget.zoom(zoom_options);
      }
    };

    this.loadPhotoSwipe = function () {
      var that = this;

      if (!rtwpvg.enable_lightbox) {
        return;
      }

      this._item.off('click', '.rtwpvg-trigger');

      this._item.on('click', '.rtwpvg-trigger', function (event) {
        that.openPhotoSwipe(event);
      });

      if (rtwpvg.lightbox_image_click) {
        this._item.off('click', '.rtwpvg-gallery-image');

        this._item.on('click', '.rtwpvg-gallery-image', function (event) {
          that.openPhotoSwipe(event);
        });
      }
    };

    this.openPhotoSwipe = function (event) {
      event.preventDefault();

      if (typeof PhotoSwipe === 'undefined') {
        return false;
      }

      var that = this;
      var pswpElement = $('.pswp')[0],
          items = this.getGalleryItems();
      var options = $.extend({
        index: this._slider.slick('slickCurrentSlide')
      }, wc_single_product_params.photoswipe_options);
      var photoSwipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
      photoSwipe.listen('close', function () {
        that.stopVideo(pswpElement);
      });
      photoSwipe.listen('afterChange', function () {
        that.stopVideo(pswpElement);
      });
      photoSwipe.init();
    };

    this.getGalleryItems = function () {
      var _slides = this._slider.slick('getSlick').$slides,
          items = [];

      if (_slides.length > 0) {
        _slides.each(function (i, el) {
          var img = $(el).find('img, iframe, video');
          var tag = $(img).prop("tagName").toLowerCase();
          var src = void 0,
              item = void 0;

          switch (tag) {
            case 'img':
              var large_image_src = img.attr('data-large_image'),
                  large_image_w = img.attr('data-large_image_width'),
                  large_image_h = img.attr('data-large_image_height');
              item = {
                src: large_image_src,
                w: large_image_w,
                h: large_image_h,
                title: img.attr('data-caption') ? img.attr('data-caption') : img.attr('title')
              };
              break;

            case 'iframe':
              src = img.attr('src');
              item = {
                html: '<iframe class="rtwpvg-lightbox-iframe" src="' + src + '" style="width: 100%; height: 100%; margin: 0;padding: 0; background-color: #000000" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
              };
              break;

            case 'video':
              src = img.attr('src');
              item = {
                html: '<video class="rtwpvg-lightbox-video" controls controlsList="nodownload" src="' + src + '" style="width: 100%; height: 100%; margin: 0;padding: 0; background-color: #000000"></video>'
              };
              break;
          }

          items.push(item);
        });
      }

      return items;
    };

    this.destroySlider = function () {
      this._slider.html('');

      this._thumbnail.html('');

      try {
        if (this._slider.hasClass('slick-initialized')) {
          this._slider.slick('unslick');
        }

        if (this._thumbnail.hasClass('slick-initialized')) {
          this._thumbnail.slick('unslick');
        }
      } catch (e) {}

      this._item.trigger('rtwpvg_slider_destroy');
    };

    this.loadGallery = function (images) {
      var that = this;
      var hasGallery = images.length > 1;

      this._item.trigger('before_rtwpvg_load', [images]);

      this.destroySlider();
      var slider_html = images.map(function (image) {
        var template = wp.template('rtwpvg-slider-template');
        return template(image);
      }).join('');
      var thumbnail_html = images.map(function (image) {
        var template = wp.template('rtwpvg-thumbnail-template');
        return template(image);
      }).join('');

      this._slider.html(slider_html);

      if (hasGallery) {
        this._target.addClass('rtwpvg-has-product-thumbnail');

        this._thumbnail.html(thumbnail_html);
      } else {
        this._target.removeClass('rtwpvg-has-product-thumbnail');

        this._thumbnail.html('');
      }

      setTimeout(function () {
        that.imagesLoaded();
      }, 1);
    };

    this.resetGallery = function () {
      var that = this;

      if (this._default_gallery_images.length > 0) {
        this.loadGallery(this._default_gallery_images);
      } else {
        setTimeout(function () {
          that.removeLoading();
        }, 1);
      }
    };

    this.imagesLoaded = function () {
      var that = this;

      if ($.fn.imagesLoaded.done) {
        this._item.trigger('rtwpvg_image_loading', [that]);

        this._item.trigger('rtwpvg_image_loaded', [that]);

        return;
      }

      this._item.imagesLoaded().progress(function (instance, image) {
        that._item.trigger('rtwpvg_image_loading', [that]);
      }).done(function (instance) {
        that._item.trigger('rtwpvg_image_loaded', [that]);
      });
    };

    this.loadVariationGallery = function () {
      var that = this;

      this._variation_form.off('reset_image.rtwpvg');

      this._variation_form.off('click.rtwpvg');

      this._variation_form.off('show_variation.rtwpvg');

      if (rtwpvg.reset_on_variation_change) {
        this._variation_form.on('reset_image.rtwpvg', function (event) {
          that.addLoading();
          that.resetGallery();
        });
      } else {
        this._variation_form.on('click.rtwpvg', '.show_variation', function (event) {
          that.addLoading();
          that.resetGallery();
        });
      }

      this._variation_form.on('show_variation.rtwpvg', function (event, variation) {
        that.addLoading();
        that.loadGallery(variation.variation_gallery_images);
      });
    };

    this.loadEvents = function () {
      this._item.on('rtwpvg_image_loaded', this.init.bind(this));
    };

    this.init = function (e) {
      var that = this;
      setTimeout(function () {
        that.loadSlider();
        that.callZoom();
        that.loadPhotoSwipe();
      }, 1);
    };

    this.start = function () {
      if (this._is_bundle_product) {
        this._product_id = this._variation_form.data('bundle_id');
      }

      this.loadDefaultGalleryImages();
      this.loadEvents();

      if (this.is_variation_product) {
        this.loadSlider();
        this.callZoom();
        this.loadPhotoSwipe();
      }

      if (!this.is_variation_product || this._is_bundle_product) {
        this.imagesLoaded();
      }

      if (!this._is_bundle_product) {
        this.loadVariationGallery();
      }

      this._variation_form.trigger('reload_product_variations');

      $(document).trigger('rtwpvg_loaded');
    };

    this.start();
    return this;
  };

  $(window).on('load', function () {
    $('.rtwpvg-wrapper:not(.rtwpvg-product-type-variable)').rtWpVGallery();
  });
  $(document).on('wc_variation_form', '.variations_form', function () {
    $('.rtwpvg-wrapper').rtWpVGallery();
  }); // Support for Jetpack's Infinite Scroll,

  $(document.body).on('post-load', function () {
    $('.rtwpvg-wrapper').rtWpVGallery();
  });
  $(document.body).on('jckqv_open', function () {
    $('.rtwpvg-wrapper').rtWpVGallery();
  }); // Support for WooCommerce Quick View

  $(document.body).on('quick-view-displayed', function () {
    $('.rtwpvg-wrapper').rtWpVGallery();
  }); // YITH Quickview

  $(document).on('qv_loader_stop', function () {
    $('.rtwpvg-wrapper:not(.rtwpvg-product-type-variable)').rtWpVGallery();
  });
})(jQuery);
