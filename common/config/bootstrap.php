<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@uploads', dirname(__DIR__) . '/../frontend/web/uploads');
Yii::setAlias('@placeholders', dirname(dirname(__DIR__)) . '/frontend/placeholders');
Yii::setAlias('frontendUrl', 'http://frontend');