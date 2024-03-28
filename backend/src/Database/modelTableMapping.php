<?php

use Database\ModelTableMapper;



ModelTableMapper::registerMapping('User', 'UserTableManager', 'users');
ModelTableMapper::registerMapping('ABCModel', 'ABCTableManager', 'abc');

