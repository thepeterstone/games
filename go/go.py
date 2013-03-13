import sys, pygame

def intro():
    screen.fill(bg_color)
    pygame.time.wait(200)

    main_loop()

def main_loop():
    while 1:
        for event in pygame.event.get():
            if event.type == pygame.QUIT: outro()
            else: handle_event(event)

        paint_background()
        paint_pieces()

        pygame.display.update()
        pygame.time.wait(5)

def outro():
    screen.fill(bg_color)
    sys.exit()

def paint_background():
    screen.blit(board, board_pos)
    font = pygame.font.Font(None, 22)
    text = font.render("Next:", 0, (0,0,0))
    screen.blit(text, (2,44))
    font = pygame.font.Font(None, 42)
    title = font.render("Go", 0, (62,62,62))
    titlepos = title.get_rect()
    titlepos.centerx = x_offset / 2
    screen.blit(title, titlepos)

    if next_move==1:
        screen.blit(black_piece, (40,40))
    else:
        screen.blit(white_piece, (40,0))

def paint_pieces():
    x = 0;
    for row in stones:
        y = 0;
        for position in row:
            if position == 1:
                screen.blit(black_piece, (x * spacing + x_offset, y * spacing + y_offset))
            elif position == 2:
                screen.blit(white_piece, (x * spacing + x_offset, y * spacing + y_offset))
            y += 1
        x += 1

def init_stones(size=24):
    return  [[0 for col in range(size)] for row in range(size)]

def handle_event(event):
    if event.type == pygame.MOUSEBUTTONDOWN:
        pos = pygame.mouse.get_pos()
        x = (pos[0] - x_offset)
        y = (pos[1] - y_offset)

        tolerance = 20
        if x % spacing < tolerance:
            if y % spacing < tolerance:
                global next_move
                stones[x / spacing][y / spacing] = next_move
                next_move = 2 if next_move==1 else 1


if __name__=='__main__':
    pygame.init()
    next_move = 1
    screen_size = 640, 480
    bg_color = 174,174,192
    screen = pygame.display.set_mode(screen_size)
    stones = init_stones()
    bg_offset = screen_size[0] - screen_size[1]
    x_offset = 5
    y_offset = 5
    if bg_offset > 0:
        board_size = (screen_size[1], screen_size[1])
        board_pos = (bg_offset, 0)
        x_offset += bg_offset
        orientation = 'horizontal'
    else:
        sys.exit()

    spacing = 25

    board = pygame.image.load("resources/board.png").convert()
    board = pygame.transform.scale(board, board_size)
    black_piece = pygame.image.load("resources/black-stone.gif")
    black_piece = pygame.transform.scale(black_piece, (board_size[0] / 24, board_size[1] / 24))
    white_piece = pygame.image.load("resources/white-stone.gif")
    white_piece = pygame.transform.scale(white_piece, (board_size[0] / 24, board_size[1] / 24))

    intro()