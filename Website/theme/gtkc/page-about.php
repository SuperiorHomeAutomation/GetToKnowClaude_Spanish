<?php
/* Template Name: About */
get_header();
?>

<section class="about-hero">
  <div class="container">
    <div class="about-hero__inner">
      <div>
        <div class="about-hero__photo" aria-hidden="true"></div>
      </div>
      <div>
        <h1 class="about-hero__name">Parmod K. Gandhi</h1>
        <p class="about-hero__role">Author &nbsp;·&nbsp; Engineer &nbsp;·&nbsp; Port Colborne, Ontario</p>
        <p class="about-hero__bio-intro">
          Fifty years of computing. One book to share what he's learned — and one AI to help him write it.
        </p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container container--text">
    <div class="prose">

      <h2>About the Author</h2>

      <p>
        Parmod K. Gandhi grew up fifty kilometres from New Delhi, came to Canada at twenty-one with a suitcase and a visa,
        and built his first computers by hand before most people had heard the word <em>microcomputer</em>.
      </p>

      <p>
        His career spans the full arc of the computing revolution. He wrote his first code in Assembly and Fortran
        on DEC minicomputers and Omron microcontrollers in the 1970s. He spent eight years at Ontario Hydro
        mastering systems nobody else fully understood. He did independent research in speech recognition at a time
        when talking to a computer was considered exotic — and earned an appointment at Carnegie Mellon University
        from Jaime Carbonell, one of the founding figures of machine learning.
      </p>

      <p>
        After leaving Ontario Hydro in 1987, he stepped into the uncertain world of freelance work and never looked back.
        Through Superior Home Automation Corp., based in Port Colborne, Ontario, he has spent nearly four decades
        solving problems that most people are told require an expert.
      </p>

      <p>
        In 2020, when the world moved to video calls, he had a hardware-based noise cancellation microphone sitting in a box —
        four years in development — that could filter out vacuum cleaners, barking dogs, and screaming children.
        The product existed. The need existed. They never found each other.
      </p>

      <p>
        That experience is part of why this book exists. Claude is the bridge that was missing. Not just for marketing —
        for everything that turns a brilliant builder into a complete business.
      </p>

      <h2>About This Book</h2>

      <p>
        <em>Get to Know Claude: Your AI Thinking Partner</em> is a beginner-friendly, twelve-chapter guide to using
        Claude AI for real-world tasks. It was written for people who are curious, capable, and tired of being told
        they need a technical background to use powerful tools.
      </p>

      <p>
        The book was itself developed using AI tools. Technical details were verified. Language was refined.
        Real problems encountered during writing were solved with AI assistance and documented as examples.
        The book you hold is evidence of what Claude can do.
      </p>

      <p>
        The foreword was written by Claude.
      </p>

      <h2>About This Website</h2>

      <p>
        GetToKnowClaude.com is the companion site to the book. It publishes new articles expanding on the book's
        topics, maintains an errata page for any corrections found after publication, and keeps readers informed
        of what's coming next.
      </p>

      <p>
        The book is available exclusively on Kindle (Amazon) and in hardcover through Lulu.
        Articles on this site are free to read — no account required.
      </p>

      <h2>Publisher</h2>

      <p>
        <em>Get to Know Claude</em> is published by <strong>Superior Home Automation Corp.</strong>,
        Port Colborne, Ontario, Canada.
      </p>

      <p style="margin-top:32px;">
        <a href="<?php echo home_url('/articles'); ?>" class="btn btn--teal">Browse Articles</a>
        &nbsp;
        <a href="https://www.amazon.com" target="_blank" rel="noopener" class="btn btn--primary">Buy on Kindle</a>
      </p>

    </div>
  </div>
</section>

<?php get_footer(); ?>
