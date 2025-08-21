<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
    <channel>
        <title><?php echo htmlspecialchars($rssData['title']); ?></title>
        <description><?php echo htmlspecialchars($rssData['description']); ?></description>
        <link><?php echo htmlspecialchars($rssData['link']); ?></link>
        <language>hr</language>
        <lastBuildDate><?php echo date('r'); ?></lastBuildDate>
        
        <?php foreach ($rssData['movies'] as $movie): ?>
        <item>
            <title><?php echo htmlspecialchars($movie['title']) . ' (' . $movie['year'] . ')'; ?></title>
            <description><?php echo htmlspecialchars($movie['plot'] ?: 'Film: ' . $movie['title'] . ' iz ' . $movie['year'] . '. godine.'); ?></description>
            <link><?php echo $rssData['link'] . '/?page=movies&amp;action=show&amp;id=' . $movie['id']; ?></link>
            <guid><?php echo $rssData['link'] . '/?page=movies&amp;action=show&amp;id=' . $movie['id']; ?></guid>
            <pubDate><?php echo date('r', strtotime($movie['created_at'])); ?></pubDate>
            <?php if ($movie['genre_name']): ?>
            <category><?php echo htmlspecialchars($movie['genre_name']); ?></category>
            <?php endif; ?>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>