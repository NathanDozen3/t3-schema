<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php foreach( $args[ 'faqs' ] ?? [] as $key => $faq ): ?>
            {
                "@type": "Question",
                "name": "<?php echo $faq->question; ?>",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "<?php echo $faq->answer; ?>"
                }
            }<?php if( $key !== count( $args[ 'faqs' ] ) - 1 ) echo ','; ?>
        <?php endforeach; ?>
    ]
}
</script>
