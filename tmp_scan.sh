#!/bin/bash
for p in / /shop /contact /faq /shop/akajiri /shop/roar-of-the-tiger; do
  wc=$(curl -s http://127.0.0.1:8000$p | grep -ci 'whatsapp')
  tg=$(curl -s http://127.0.0.1:8000$p | grep -ci 'telegram')
  ig=$(curl -s http://127.0.0.1:8000$p | grep -ci 'instagram')
  echo "$p: whatsapp=$wc telegram=$tg instagram=$ig"
done
