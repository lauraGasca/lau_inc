<div class="pagination">
    <ul>
        <li>
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=1">
    [?php echo __('First page', array(), 'sf_admin') ?]
  </a>
        </li>
        <li>
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getPreviousPage() ?]">
    [?php echo __('Previous page', array(), 'sf_admin') ?]
  </a>
</li>
<li>
  [?php foreach ($pager->getLinks() as $page): ?]
    [?php if ($page == $pager->getPage()): ?]
      <strong>[?php echo $page ?]</strong>
    [?php else: ?]
      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $page ?]">[?php echo $page ?]</a>
    [?php endif; ?]
  [?php endforeach; ?]
    
</li>
        <li>
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getNextPage() ?]">
    [?php echo __('Next page', array(), 'sf_admin') ?]
  </a>
</li>
        <li>
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getLastPage() ?]">
    [?php echo __('Last page', array(), 'sf_admin') ?]
  </a>
            </li>
        
    </ul>
</div>
