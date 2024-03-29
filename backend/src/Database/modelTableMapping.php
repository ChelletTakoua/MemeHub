<?php

use Database\ModelTableMapper;



ModelTableMapper::registerMapping('User', 'UserTableManager', 'users');
ModelTableMapper::registerMapping('Like', 'LikeTableManager', 'likes');
ModelTableMapper::registerMapping('TextBlock', 'TextBlockTableManager', 'text_blocks');
ModelTableMapper::registerMapping('Meme', 'MemeTableManager', 'memes');
ModelTableMapper::registerMapping('Report', 'ReportTableManager', 'reports');
ModelTableMapper::registerMapping('Template', 'TemplateTableManager', 'templates');
ModelTableMapper::registerMapping('BlockedMeme', 'BlockedMemeTableManager', 'blocked_memes');



