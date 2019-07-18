<script type="application/ld+json">
{
  "@context": "<?php echo $context; ?>",
  "@type": "<?php echo $type; ?>",
  "name": "<?php echo $name; ?>",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo $score; ?>",
    "ratingCount": "<?php echo $count; ?>",
    "bestRating": "<?php echo $stars; ?>",
    "worstRating": "1"
  }
}
</script>
