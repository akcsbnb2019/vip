<!-- Panels Overlay -->
  <div class="panel-overlay"></div>
 
  <!-- Left Panel with Reveal effect -->
  <div class="panel panel-left panel-cover" id="leftPanel">
    <div class="content-block">
      <div class="welcome">
        欢迎登陆:<span class="color-red">&nbsp;<?=$_SESSION['loginname']?></span>
      </div>
      <div class="list-block accordion-list">
      <ul>
        <li class="accordion-item" onclick="window.location='/site/main'"><a href="#" class="item-content item-link">
          <div class="item-inner">
            <div class="item-title"><i class="fa fa-podcast fa-lg color-pink"></i>系统公告</div>
          </div></a>
          <div class="accordion-item-content">
            <div class="list-block">
            </div>
          </div>
        </li>
        <li class="accordion-item"><a href="#" class="item-content item-link">
          <div class="item-inner">
            <div class="item-title"><i class="fa fa-user-o fa-lg color-red"></i>用户中心</div>
          </div></a>
          <div class="accordion-item-content">
            <div class="list-block">
              <ul>
                <li class="item-content">
                  <div class="item-inner">
                    <div class="item-title" onclick="window.location='/user/index'">我的信息</div>
                    <div class="item-title" onclick="window.location='/user/edit'">资料修改</div>
                  </div>
                </li>
                <li class="item-content">
                  <div class="item-inner">
                    <div class="item-title" onclick="window.location='/user/jifen'">福利兑换记录</div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li class="accordion-item"><a href="#" class="item-content item-link">
          <div class="item-inner">
            <div class="item-title"><i class="fa fa-street-view fa-lg color-blue"></i>图谱管理</div>
          </div></a>
          <div class="accordion-item-content">
            <div class="list-block">
              <ul>
                <li class="item-content">
                  <div class="item-inner">
                    <div class="item-title" onclick="window.location='/user/jifen'">邀请图谱</div>
                    <div class="item-title" onclick="window.location='/user/jifen'">会员图谱</div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li class="accordion-item"><a href="#" class="item-content item-link">
          <div class="item-inner">
            <div class="item-title"><i class="fa fa-btc fa-lg color-orange"></i>积分管理</div>
          </div></a>
          <div class="accordion-item-content">
            <div class="list-block">
              <ul>
                <li class="item-content">
                  <div class="item-inner">
                    <div class="item-title" onclick="window.location='/user/jifen'">积分记录</div>
                    <div class="item-title" onclick="window.location='/user/jifen'">积分明细</div>
                  </div>
                </li>
                <li class="item-content">
                  <div class="item-inner">
                    <div class="item-title" onclick="window.location='/user/jifen'">会员转账</div>
                    <div class="item-title" onclick="window.location='/user/jifen'">转账记录</div>
                  </div>
                </li>
                <li class="item-content">
                  <div class="item-inner">
                    <div class="item-title" onclick="window.location='/user/jifen'">积分提现</div>
                    <div class="item-title" onclick="window.location='/user/jifen'">积分兑换</div>
                  </div>
                </li>
                <li class="item-content">
                  <div class="item-inner">
                    <div class="item-title" onclick="window.location='/user/jifen'">兑换记录</div>
                    <div class="item-title" onclick="window.location='/user/jifen'">爱心基金</div>
                  </div>
                </li>               
              </ul>
            </div>
          </div>
        </li>
        <li class="accordion-item"><a href="#" class="item-content item-link">
          <div class="item-inner">
            <div class="item-title"><i class="fa fa-edit fa-lg color-green"></i>留言管理</div>
          </div></a>
          <div class="accordion-item-content">
          <div class="list-block">
            <ul>
              <li class="item-content">
                <div class="item-inner">
                  <div class="item-title" onclick="window.location='/user/jifen'">收到的留言</div>
                  <div class="item-title" onclick="window.location='/user/jifen'">发送的留言</div>
                </div>
              </li>
              <li class="item-content">
                <div class="item-inner">
                  <div class="item-title" onclick="window.location='/user/jifen'">发送新留言</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        </li>
        <li><a href="javascript:document.app.logout();" class="item-content item-link">
          <div class="item-inner">
            <div class="item-title"><i class="fa fa-sign-out fa-lg color-gray"></i>退出系统</div>
          </div></a>
        </li>
      </ul>
      </div>
      <p><a href="#" class="btn close-panel">关闭面板</a></p>
    </div>
  </div>
 
  <!-- Speed Dial Wrap -->
  <div class="speed-dial" style="opacity: 0.7;">
    <!-- FAB inside will open Speed Dial actions -->
    <a href="#" class="floating-button">
      <!-- First icon is visible when Speed Dial actions are closed -->
      <i class="fa fa-plus fa-2x"></i>
      <!-- Second icon is visible when Speed Dial actions are opened -->
      <i class="fa fa-remove fa-2x"></i>
    </a>
    <!-- Speed Dial Actions -->
    <div class="speed-dial-buttons">
      <!-- First Speed Dial button -->
      <a href="#" class="open-panel">
        <i class="fa fa-reorder fa-lg"></i>
      </a>
      <!-- Second Speed Dial  button -->
      <a href="javascript:window.location='/site/main'">
        <i class="fa fa-home fa-lg"></i>
      </a>
      <!-- Third Speed Dial  button -->
      <a href="javascript:$$('div.page-content').scrollTop(0, 800);">
        <i class="fa fa-arrow-up fa-lg"></i>
      </a>
    </div>
  </div>
  <!-- End of Speed Dial -->
  <div class="page-content">
    <!-- Top Navbar-->
    <div class="navbar">
      <div class="navbar-inner">
        <div class="item-media open-panel">
          <i class="fa fa-reorder fa-lg color-green"></i>&nbsp;&nbsp;
          <?=$this->title?>
        </div>
      </div>
    </div>